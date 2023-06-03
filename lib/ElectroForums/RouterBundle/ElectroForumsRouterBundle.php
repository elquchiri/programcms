<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\RouterBundle;


class ElectroForumsRouterBundle extends \ElectroForums\CoreBundle\ElectroForumsCoreBundle
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