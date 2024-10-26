<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle;

use ProgramCms\CatalogBundle\ProgramCmsCatalogBundle;
use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\MarketingBundle\ProgramCmsMarketingBundle;
use ProgramCms\RewriteBundle\Helper\Data;
use ProgramCms\UserBundle\ProgramCmsUserBundle;

/**
 * Class ProgramCmsRewriteBundle
 * @package ProgramCms\ProgramCmsRewriteBundle
 */
class ProgramCmsRewriteBundle extends ProgramCmsCoreBundle
{
    public const VERSION = '1.0.0';

    public function boot()
    {
        parent::boot();
        $this->loadRoutes();
    }

    /**
     * Loading Routes from RewriteUrlLoader to support Url Rewriting
     */
    private function loadRoutes()
    {
        $routes = $this->container->get('routing.loader')->load('.', Data::URL_REWRITE_LOADER);
        $this->container->get('router')->getRouteCollection()->addCollection($routes);
    }

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [
            ProgramCmsCoreBundle::class,
            ProgramCmsMarketingBundle::class,
            ProgramCmsUserBundle::class,
            ProgramCmsCatalogBundle::class
        ];
    }
}