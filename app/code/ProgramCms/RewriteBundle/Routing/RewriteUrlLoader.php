<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Routing;

use ProgramCms\RewriteBundle\Controller\Router\RouteController;
use ProgramCms\RewriteBundle\Helper\Data;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RewriteUrlLoader
 * @package ProgramCms\RewriteBundle\Routing
 */
class RewriteUrlLoader extends Loader
{
    /**
     * @var RouteCollection
     */
    protected RouteCollection $routeCollection;

    /**
     * RewriteUrlLoader constructor.
     * @param string|null $env
     */
    public function __construct(
        string $env = null
    )
    {
        parent::__construct($env);
        $this->routeCollection = new RouteCollection();
    }

    /**
     * @param mixed $resource
     * @param string|null $type
     * @return RouteCollection
     */
    public function load(mixed $resource, string $type = null)
    {
        $route = new Route(
            '/{parameters<.*>?}',
            [
                '_controller' => RouteController::class . '::' . \ProgramCms\RouterBundle\Helper\Data::PROGRAMCMS_ROUTING_CLASS_METOHD
            ]
        );

        $this->routeCollection->add('frontend_rewrite_router_route', $route);

        return $this->routeCollection;
    }

    /**
     * @param mixed $resource
     * @param string|null $type
     * @return bool
     */
    public function supports(mixed $resource, string $type = null)
    {
        return $type === Data::URL_REWRITE_LOADER;
    }
}