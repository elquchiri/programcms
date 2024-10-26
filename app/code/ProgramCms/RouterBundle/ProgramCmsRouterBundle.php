<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RouterBundle;

use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\RouterBundle\Helper\Data;

/**
 * Class ProgramCmsRouterBundle
 * @package ProgramCms\RouterBundle
 */
class ProgramCmsRouterBundle extends ProgramCmsCoreBundle
{
    public const VERSION = '1.0.0';

    public function boot()
    {
        parent::boot();
        $this->loadRoutes();
    }

    /**
     * Used to skip loading ProgramCms Loader Resource from config/routes
     */
    private function loadRoutes()
    {
        $routes = $this->container->get('routing.loader')->load('.', Data::PROGRAMCMS_ROUTING_LOADER);
        $this->container->get('router')->getRouteCollection()->addCollection($routes);
    }

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [
            ProgramCmsCoreBundle::class,
        ];
    }
}