<?php


namespace ElectroForums\RouterBundle\Routing;


use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class ElectroforumsRouteLoader extends Loader
{

    const ELECTROFORUMS_ROUTING_CLASS_METOHD = 'execute';

    private $routes;
    private ContainerInterface $container;
    private string $frontName;
    private bool $isLoaded;

    public function __construct(
        ContainerInterface $container,
        string $env = null
    )
    {
        parent::__construct($env);
        $this->routes = new RouteCollection();
        $this->container = $container;
        $this->frontName = '';
        $this->isLoaded = false;
    }

    public function supports(mixed $resource, string $type = null): bool
    {
        return $type === \ElectroForums\RouterBundle\Helper\Data::ELECTROFORUMS_ROUTING_LOADER;
    }

    public function load(mixed $resource, string $type = null): RouteCollection
    {
        if (true === $this->isLoaded) {
            throw new \RuntimeException('Do not add the "electroforums" loader twice');
        }

        // Get all bundles
        $bundles = $this->container->getParameter('kernel.bundles');

        foreach ($bundles as $bundleName => $bundleClass) {
            $reflectedBundle = new \ReflectionClass($bundleClass);
            if ($reflectedBundle->hasMethod('isElectroForumsBundle')) {
                $bundleDirectory = dirname($reflectedBundle->getFileName());
                $routesFilePath = $bundleDirectory . '/Resources/config/routes.yaml';

                // Load the configuration file
                if (file_exists($routesFilePath)) {
                    $router = \Symfony\Component\Yaml\Yaml::parseFile($routesFilePath);
                    if(isset($router['router'])) {
                        $router = $router['router'];
                        if (isset($router['standard'])) {
                            foreach ($router['standard'] as $key => $route) {
                                $this->frontName = $route['frontName'];
                            }
                        }
                    }

                    if(!empty($this->frontName)) {
                        $controllersPath = $bundleDirectory . '/Controller';

                        $files = iterator_to_array(new \RecursiveIteratorIterator(
                            new \RecursiveCallbackFilterIterator(
                                new \RecursiveDirectoryIterator($controllersPath, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS),
                                function (\SplFileInfo $current) {
                                    return !str_starts_with($current->getBasename(), '.');
                                }
                            ),
                            \RecursiveIteratorIterator::LEAVES_ONLY
                        ));

                        foreach ($files as $file) {
                            if (!$file->isFile() || !str_ends_with($file->getFilename(), '.php')) {
                                continue;
                            }

                            if ($class = $this->findClass($file)) {
                                $refl = new \ReflectionClass($class);
                                if ($refl->isAbstract()) {
                                    continue;
                                }

                                $this->addRoute($class);
                            }
                        }
                    }
                }
            }
        }

        $this->isLoaded = true;

        return $this->routes;
    }

    public function addRoute($controller)
    {
        $parts = explode('\\', $controller);
        $namespace = $parts[0];
        $bundleName = $parts[1];
        $folderName = $parts[count($parts) - 2];
        $className = preg_replace('/(.)(Controller)/', '$1', $parts[count($parts) - 1]);

        $path = strtolower($this->frontName . '/' . $folderName . '/' . $className) . '/{parameters<.*>?}';
        $routeName = strtolower($namespace . '_' . $bundleName . '_' . $folderName . '_' . $className);

        // Create a new route object with the controller and action
        $defaults = [
            '_controller' => $controller . '::' . self::ELECTROFORUMS_ROUTING_CLASS_METOHD
        ];
        $requirements = [

        ];

        $route = new Route('/' . $path, $defaults, $requirements, ['_locale' => 'en']);

        // Add the route to the collection
        $this->routes->add($routeName, $route);
    }

    /**
     * Returns the full class name for the first class in the file.
     */
    protected function findClass(string $file): string|false
    {
        $class = false;
        $namespace = false;
        $tokens = token_get_all(file_get_contents($file));

        if (1 === \count($tokens) && \T_INLINE_HTML === $tokens[0][0]) {
            throw new \InvalidArgumentException(sprintf('The file "%s" does not contain PHP code. Did you forgot to add the "<?php" start tag at the beginning of the file?', $file));
        }

        $nsTokens = [\T_NS_SEPARATOR => true, \T_STRING => true];
        if (\defined('T_NAME_QUALIFIED')) {
            $nsTokens[\T_NAME_QUALIFIED] = true;
        }
        for ($i = 0; isset($tokens[$i]); ++$i) {
            $token = $tokens[$i];
            if (!isset($token[1])) {
                continue;
            }

            if (true === $class && \T_STRING === $token[0]) {
                return $namespace . '\\' . $token[1];
            }

            if (true === $namespace && isset($nsTokens[$token[0]])) {
                $namespace = $token[1];
                while (isset($tokens[++$i][1], $nsTokens[$tokens[$i][0]])) {
                    $namespace .= $tokens[$i][1];
                }
                $token = $tokens[$i];
            }

            if (\T_CLASS === $token[0]) {
                // Skip usage of ::class constant and anonymous classes
                $skipClassToken = false;
                for ($j = $i - 1; $j > 0; --$j) {
                    if (!isset($tokens[$j][1])) {
                        if ('(' === $tokens[$j] || ',' === $tokens[$j]) {
                            $skipClassToken = true;
                        }
                        break;
                    }

                    if (\T_DOUBLE_COLON === $tokens[$j][0] || \T_NEW === $tokens[$j][0]) {
                        $skipClassToken = true;
                        break;
                    } elseif (!\in_array($tokens[$j][0], [\T_WHITESPACE, \T_DOC_COMMENT, \T_COMMENT])) {
                        break;
                    }
                }

                if (!$skipClassToken) {
                    $class = true;
                }
            }

            if (\T_NAMESPACE === $token[0]) {
                $namespace = true;
            }
        }

        return false;
    }
}