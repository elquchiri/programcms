<?php


namespace ElectroForums\RouterBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;

class ElectroForumsRouterBundle extends Bundle
{
    public const VERSION = '1.0.0';

    public function boot()
    {
        parent::boot();
        $this->loadRoutes();
    }

    /**
     * Used to skip loading electroforums Loader Resource from config/routes
     */
    private function loadRoutes()
    {
        $routes = $this->container->get('routing.loader')->load('.', \ElectroForums\RouterBundle\Helper\Data::ELECTROFORUMS_ROUTING_LOADER);

        $this->container->get('router')->getRouteCollection()->addCollection($routes);
    }
}