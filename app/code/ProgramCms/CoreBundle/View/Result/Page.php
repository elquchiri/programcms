<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Result;

use Symfony\Component\Form\FormInterface;

/**
 * Class Page
 * @package ProgramCms\CoreBundle\View\Result
 */
class Page extends Layout
{

    protected \ProgramCms\CoreBundle\View\Page\Config $pageConfig;
    protected \Twig\Environment $env;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        \ProgramCms\CoreBundle\View\Layout $layout
    )
    {
        parent::__construct($context, $layout);
        $this->pageConfig = $context->getPageConfig();
        $this->env = $context->getEnvironment();
        $this->layout = $layout;
    }

    /**
     * Get Page Configuration
     */
    public function getConfig()
    {
        return $this->pageConfig;
    }

    /**
     * @param array $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(array $parameters = []): \Symfony\Component\HttpFoundation\Response
    {
        $efCss = $this->layout->getCss();
        $efJs = $this->layout->getJs();
        $efTitle = $this->layout->getTitle();
        $html = $this->layout->renderPage();

        $content = $this->env->render('@ProgramCmsTheme/base.html.twig', ['efCss' => $efCss, 'efJs' => $efJs, 'efTitle' => $efTitle, 'html' => $html]);

        $response ??= new \Symfony\Component\HttpFoundation\Response();
        if (200 === $response->getStatusCode()) {
            foreach ($parameters as $v) {
                if ($v instanceof FormInterface && $v->isSubmitted() && !$v->isValid()) {
                    $response->setStatusCode(422);
                    break;
                }
            }
        }
        $response->setContent($content);
        return $response;
    }
}