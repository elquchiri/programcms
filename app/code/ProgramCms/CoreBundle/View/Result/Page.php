<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Result;

/**
 * Class Page
 * @package ProgramCms\CoreBundle\View\Result
 */
class Page extends Layout
{

    protected \ProgramCms\CoreBundle\View\Page\Config $pageConfig;
    protected \ProgramCms\RouterBundle\Service\Request $request;
    protected \Twig\Environment $twig;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context
    )
    {
        $this->pageConfig = $context->getPageConfig();
        $this->request = $context->getRequest();
        $this->twig = $context->getEnvironment();
    }

    /**
     * Get Page Configuration
     */
    public function getConfig()
    {
        return $this->pageConfig;
    }

    public function render(array $parameters = []): string
    {
        $currentRouteName = $this->request->getCurrentRouteName();

        $content = $this->twig->render($currentRouteName, $parameters);

        $response ??= new \Symfony\Component\HttpFoundation\Response();
        $response->setContent($content);

        return $response;
    }
}