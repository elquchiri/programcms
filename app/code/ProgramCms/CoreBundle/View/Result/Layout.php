<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Result;

use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\ThemeBundle\Loader\LayoutLoader;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Layout
 * @package ProgramCms\CoreBundle\View\Result
 */
class Layout extends AbstractResult
{
    const LAYOUT_EXTENSION = '.yaml';

    /**
     * @var \ProgramCms\CoreBundle\View\Layout
     */
    protected \ProgramCms\CoreBundle\View\Layout $layout;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Environment
     */
    protected Environment $env;

    /**
     * @var BundleManager
     */
    private BundleManager $bundleManager;

    /**
     * @var string|null
     */
    protected string $currentLayout;

    /**
     * @var LayoutLoader
     */
    protected LayoutLoader $layoutLoader;

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __construct(Context $context, $currentLayout = '')
    {
        $this->request = $context->getRequest();
        $this->env = $context->getEnvironment();
        $this->layout = $context->getLayout();
        $this->bundleManager = $context->getBundleManager();
        $this->currentLayout = $currentLayout;
        $this->layoutLoader = $context->getLayoutLoader();

        // Construct Layout Elements
        $this->_initLayout();
    }

    /**
     * @throws \ReflectionException
     */
    private function _initLayout()
    {
        $routeName = $this->request->getCurrentRequest()->attributes->get('_route');
        $routes = $this->bundleManager->getContainer()->get('router')->getRouteCollection();
        $routeDefaults = $routes->get($routeName)->getDefaults();
        $currentRouteName = $routeDefaults['target_path'] ?? $this->request->getCurrentRouteName();
        if(!empty($this->currentLayout)) {
            $currentRouteName = $this->currentLayout;
        }

        $this->layoutLoader->renderLayout($currentRouteName . self::LAYOUT_EXTENSION);

        // Generate Layout Elements
        $this->getLayout()->generateElements();
    }

    /**
     * @return \ProgramCms\CoreBundle\View\Layout
     */
    public function getLayout(): \ProgramCms\CoreBundle\View\Layout
    {
        return $this->layout;
    }

    public function setCurrentLayout(string $layout): static
    {
        $this->currentLayout = $layout;
        return $this;
    }

    /**
     * Created for override
     * @param array $parameters
     * @return Response
     */
    public function render(array $parameters = []): Response
    {
        // Please override this methode
    }
}