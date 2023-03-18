<?php


namespace ElectroForums\ThemeBundle\Twig;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Error\LoaderError;
use Twig\Source;


class LayoutLoader implements \Twig\Loader\LoaderInterface
{
    /** Identifier of the main namespace. */
    public const MAIN_NAMESPACE = '__main__';
    protected \Twig\Environment $environment;

    private $paths;
    private $rootPath;
    private ContainerInterface $container;
    private $cache;
    private $errorCache;

    public function __construct(
        ContainerInterface $container,
        \Twig\Environment $environment
    )
    {
        $this->container = $container;
        $this->initLayoutPaths();
        $this->environment = $environment;
    }

    private function initLayoutPaths(string $rootPath = null)
    {
        $this->rootPath = (null === $rootPath ? getcwd() : $rootPath).\DIRECTORY_SEPARATOR;
        if (null !== $rootPath && false !== ($realPath = realpath($rootPath))) {
            $this->rootPath = $realPath.\DIRECTORY_SEPARATOR;
        }

        // Get all bundles
        $bundles = $this->container->getParameter('kernel.bundles');
        foreach ($bundles as $bundleClass) {
            $reflectedBundle = new \ReflectionClass($bundleClass);
            if($reflectedBundle->hasMethod('isElectroForumsBundle') && $reflectedBundle->getMethod('isElectroForumsBundle')) {
                $bundleDirectory = dirname($reflectedBundle->getFileName());
                $layoutPath = $bundleDirectory . '/Resources/layout';
                if(is_dir($layoutPath)) {
                    $this->paths[self::MAIN_NAMESPACE][] = $layoutPath;
                }
            }
        }
    }

    public function getSourceContext(string $name): Source
    {
        if (null === $paths = $this->findTemplate($name)) {
            return new Source('', $name, '');
        }

        // Include all default layouts in bundles
        if (null === $defaultLayoutPaths = $this->findTemplate('default.layout.twig')) {
            return new Source('', $name, '');
        }

        // We can use $template = $this->environment->createTemplate($source, $path = ''); to skip using EFLayout Tag

        $source = "{% EFLayoutStarter %}";

        foreach($defaultLayoutPaths as $defaultLayoutPath) {
            $templateContent = file_get_contents($defaultLayoutPath);
            $source .= $templateContent;
        }

        foreach($paths as $path) {
            $templateContent = file_get_contents($path);
            $source .= $templateContent;
        }

        $source .= "{% endEFLayoutStarter %}";

        return new Source($source, $name, $path = '');
    }

    private function normalizeName(string $name): string
    {
        return preg_replace('#/{2,}#', '/', str_replace('\\', '/', $name));
    }

    protected function findTemplate(string $name, bool $throw = true)
    {
        $name = $this->normalizeName($name);

        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        if (isset($this->errorCache[$name])) {
            if (!$throw) {
                return null;
            }

            throw new LoaderError($this->errorCache[$name]);
        }

        try {
            list($namespace, $shortname) = $this->parseName($name);

            $this->validateName($shortname);
        } catch (LoaderError $e) {
            if (!$throw) {
                return null;
            }

            throw $e;
        }

        if (!isset($this->paths[self::MAIN_NAMESPACE]) || empty($this->paths[self::MAIN_NAMESPACE])) {
            $this->errorCache[$name] = sprintf('There are no registered paths for namespace "%s".', $namespace);

            if (!$throw) {
                return null;
            }

            throw new LoaderError($this->errorCache[$name]);
        }

        foreach ($this->paths[self::MAIN_NAMESPACE] as $path) {
            if (!$this->isAbsolutePath($path)) {
                $path = $this->rootPath . $path;
            }

            if (is_file($path.'/'.$shortname)) {
                if (false !== $realpath = realpath($path.'/'.$shortname)) {
                    $this->cache[$name][] = $realpath;
                }else{
                    $this->cache[$name][] = $path.'/'.$shortname;
                }
            }
        }

        if(isset($this->cache[$name]) && !empty($this->cache[$name])) {
            return $this->cache[$name];
        }

        $this->errorCache[$name] = sprintf('Unable to find template "%s" (looked into: %s).', $name, implode(', ', $this->paths[$namespace]));

        if (!$throw) {
            return null;
        }

        throw new LoaderError($this->errorCache[$name]);
    }

    private function validateName(string $name): void
    {
        if (false !== strpos($name, "\0")) {
            throw new LoaderError('A template name cannot contain NUL bytes.');
        }

        $name = ltrim($name, '/');
        $parts = explode('/', $name);
        $level = 0;
        foreach ($parts as $part) {
            if ('..' === $part) {
                --$level;
            } elseif ('.' !== $part) {
                ++$level;
            }

            if ($level < 0) {
                throw new LoaderError(sprintf('Looks like you try to load a template outside configured directories (%s).', $name));
            }
        }
    }

    private function isAbsolutePath(string $file): bool
    {
        return strspn($file, '/\\', 0, 1)
            || (\strlen($file) > 3 && ctype_alpha($file[0])
                && ':' === $file[1]
                && strspn($file, '/\\', 2, 1)
            )
            || null !== parse_url($file, \PHP_URL_SCHEME)
            ;
    }

    private function parseName(string $name, string $default = self::MAIN_NAMESPACE): array
    {
        if (isset($name[0]) && '@' == $name[0]) {
            if (false === $pos = strpos($name, '/')) {
                throw new LoaderError(sprintf('Malformed namespaced template name "%s" (expecting "@namespace/template_name").', $name));
            }

            $namespace = substr($name, 1, $pos - 1);
            $shortname = substr($name, $pos + 1);

            return [$namespace, $shortname];
        }

        return [$default, $name];
    }

    public function getCacheKey(string $name): string
    {
        return $name;
    }

    public function isFresh(string $name, int $time): bool
    {
        return true;
    }

    public function exists(string $name)
    {
        return true;
    }
}