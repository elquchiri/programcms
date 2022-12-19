<?php


namespace ElectroForums\RouterBundle\Config;


use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\Resource\FileResource;

class ExtraLoader extends Loader
{

    private $isLoaded = false;

    const TYPE = 'extra';

    public function supports(mixed $resource, string $type = null): bool
    {
        return $type === self::TYPE;
    }

    public function load($resource, $type=null): RouteCollection
    {
        if (true === $this->isLoaded) {
            throw new \RuntimeException('Do not add the "extra" loader twice');
        }

        $routes = new RouteCollection();

        // prepare a new route
        $path = '/extra/{parameter}';
        $defaults = [
            '_controller' => 'ElectroForums\CustomerBundle\Controller\CustomerController::index',
        ];
        $requirements = [
            'parameter' => '\d+',
        ];
        $route = new Route($path, $defaults, $requirements);

        // add the new route to the route collection
        $routeName = 'extraRoute';
        $routes->add($routeName, $route);

        $this->isLoaded = true;

        return $routes;
    }
}