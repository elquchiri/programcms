<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Controller\Router;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\RewriteBundle\Entity\UrlRewrite;
use ProgramCms\RewriteBundle\Helper\Config as ConfigHelper;
use ProgramCms\RewriteBundle\Repository\UrlRewriteRepository;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/**
 * Class RouteController
 * @package ProgramCms\RewriteBundle\Controller\Router
 */
class RouteController extends Controller
{
    /**
     * @var UrlRewriteRepository
     */
    protected UrlRewriteRepository $urlRewriteRepository;

    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * @var ConfigHelper
     */
    protected ConfigHelper $configHelper;

    /**
     * RouteController constructor.
     * @param Context $context
     * @param UrlRewriteRepository $urlRewriteRepository
     * @param BundleManager $bundleManager
     * @param ConfigHelper $configHelper
     */
    public function __construct(
        Context $context,
        UrlRewriteRepository $urlRewriteRepository,
        BundleManager $bundleManager,
        ConfigHelper $configHelper
    )
    {
        parent::__construct($context);
        $this->urlRewriteRepository = $urlRewriteRepository;
        $this->bundleManager = $bundleManager;
        $this->configHelper = $configHelper;
    }

    public function execute()
    {
        $pathInfo = ltrim($this->getRequest()->getPathInfo(), '/');
        if($this->configHelper->isRewriteEnabled()) {
            /** @var UrlRewrite $urlRewrite */
            $urlRewrite = $this->urlRewriteRepository->getByRequestPath($pathInfo);
            if ($urlRewrite) {
                $loadedRoutes = $this->bundleManager->getContainer()->get('router')->getRouteCollection();
                $targetRoute = $loadedRoutes->get('frontend_' . $urlRewrite->getTargetPath());
                $targetController = $targetRoute->getDefaults()['_controller'];
                $parameters = $this->buildParameters($urlRewrite->getArguments());
                return $this->forward(
                    $targetController,
                    [
                        '_route' => 'frontend_' . $urlRewrite->getTargetPath(),
                        'parameters' => $parameters,
                        '_route_params' => ['parameters' => $parameters]
                    ]
                );
            }
        }

        throw new RouteNotFoundException(sprintf('Unable to generate a URL for the named route "%s" as such route does not exist.', $pathInfo));
    }

    /**
     * @param array $parameters
     * @return string
     */
    private function buildParameters(string $parameters): string
    {
        if(empty($parameters)) {
            return '';
        }

        $parameters = json_decode($parameters, true);
        $params = '';
        foreach($parameters as $parameter => $value) {
            if(!empty($params)) {
                $params .= '/';
            }
            $params .= $parameter . '/' . $value;
        }
        return $params;
    }
}