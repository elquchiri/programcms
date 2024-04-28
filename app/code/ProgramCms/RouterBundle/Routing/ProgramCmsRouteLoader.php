<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RouterBundle\Routing;

use ProgramCms\CoreBundle\Data\Process\Find;
use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ReflectionException;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ProgramCmsRouteLoader
 * @package ProgramCms\RouterBundle\Routing
 */
class ProgramCmsRouteLoader extends Loader
{
    /**
     * @var Find
     */
    protected Find $find;

    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var string
     */
    private string $frontName;

    /**
     * @var string
     */
    private string $frontAdminName;

    /**
     * @var bool
     */
    private bool $isLoaded;

    /**
     * ProgramCmsRouteLoader constructor.
     * @param ContainerInterface $container
     * @param Find $find
     * @param string|null $env
     */
    public function __construct(
        ContainerInterface $container,
        Find $find,
        string $env = null
    )
    {
        parent::__construct($env);
        $this->routes = new RouteCollection();
        $this->container = $container;
        $this->frontName = '';
        $this->frontAdminName = '';
        $this->isLoaded = false;
        $this->find = $find;
    }

    /**
     * @param mixed $resource
     * @param string|null $type
     * @return bool
     */
    public function supports(mixed $resource, string $type = null): bool
    {
        return $type === \ProgramCms\RouterBundle\Helper\Data::PROGRAMCMS_ROUTING_LOADER;
    }

    /**
     * @param mixed $resource
     * @param string|null $type
     * @return RouteCollection
     * @throws ReflectionException
     */
    public function load(mixed $resource, string $type = null): RouteCollection
    {
        if (true === $this->isLoaded) {
            throw new \RuntimeException('Do not add the "programcms" loader twice');
        }

        // Get all bundles
        $bundles = $this->container->getParameter('kernel.bundles');

        foreach ($bundles as $bundleClass) {
            $reflectedBundle = new \ReflectionClass($bundleClass);
            if ($reflectedBundle->isSubclassOf(ProgramCmsCoreBundle::class)) {
                $bundleDirectory = dirname($reflectedBundle->getFileName());
                $routesFilePath = $bundleDirectory . '/Resources/config/routes.yaml';

                // Load the configuration file
                if (file_exists($routesFilePath)) {
                    $router = Yaml::parseFile($routesFilePath);
                    if(isset($router['router'])) {
                        $router = $router['router'];
                        if (isset($router[\ProgramCms\RouterBundle\Helper\Data::PROGRAMCMS_AREA_CODE_FRONTEND])) {
                            foreach ($router[\ProgramCms\RouterBundle\Helper\Data::PROGRAMCMS_AREA_CODE_FRONTEND] as $key => $route) {
                                $this->frontName = $route['frontName'];
                            }
                        }
                        if (isset($router[\ProgramCms\RouterBundle\Helper\Data::PROGRAMCMS_AREA_CODE_ADMINHTML])) {
                            foreach ($router[\ProgramCms\RouterBundle\Helper\Data::PROGRAMCMS_AREA_CODE_ADMINHTML] as $key => $route) {
                                $this->frontAdminName = $route['frontName'];
                            }
                        }
                    }

                    if(!empty($this->frontName) || !empty($this->frontAdminName)) {
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

                            if ($controllerClass = $this->find->findClass($file)) {
                                $refl = new \ReflectionClass($controllerClass);
                                if ($refl->isAbstract()) {
                                    continue;
                                }
                                $areaCode = str_contains($file->getPath(), '\\Adminhtml\\') ? 'adminhtml' : 'frontend';
                                $this->addRoute($controllerClass, $areaCode);
                            }
                        }

                        // Reset frontName
                        $this->frontName = '';
                        $this->frontAdminName = '';
                    }
                }
            }
        }

        $this->isLoaded = true;

        return $this->routes;
    }

    /**
     * @param $controllerClass
     * @param $areaCode
     */
    public function addRoute($controllerClass, $areaCode)
    {
        $parts = explode('\\', $controllerClass);

        $folderName = $parts[count($parts) - 2];
        $className = preg_replace('/(.)(Controller)/', '$1', $parts[count($parts) - 1]);

        if($areaCode == \ProgramCms\RouterBundle\Helper\Data::PROGRAMCMS_AREA_CODE_ADMINHTML) {
            $routeName = \ProgramCms\RouterBundle\Helper\Data::PROGRAMCMS_AREA_CODE_ADMINHTML . '_' . strtolower($this->frontAdminName . '_' . $folderName . '_' . $className);
            $path = \ProgramCms\RouterBundle\Helper\Data::ADMIN_ROUTE_PREFIX . '/' . strtolower($this->frontAdminName . '/' . $folderName . '/' . $className) . '/{parameters<.*>?}';
        }else{
            $routeName = \ProgramCms\RouterBundle\Helper\Data::PROGRAMCMS_AREA_CODE_FRONTEND . '_' . strtolower($this->frontName . '_' . $folderName . '_' . $className);
            $path = strtolower($this->frontName . '/' . $folderName . '/' . $className) . '/{parameters<.*>?}';
        }

        // Create a new route object with the controller and action
        $defaults = [
            '_controller' => $controllerClass . '::' . \ProgramCms\RouterBundle\Helper\Data::PROGRAMCMS_ROUTING_CLASS_METOHD
        ];
        $requirements = [];

        if($routeName == 'frontend_cms_index_index') {
            // CMS Home Page Route
            $route = new Route('/', $defaults, $requirements, ['_locale' => 'en']);
        }else {
            $route = new Route('/' . $path, $defaults, $requirements, ['_locale' => 'en']);
        }

        // Add the route to the collection
        $this->routes->add($routeName, $route);
    }
}