<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Result;

/**
 * Class Layout
 * @package ProgramCms\CoreBundle\View\Result
 */
class Layout extends AbstractResult
{
    protected \ProgramCms\CoreBundle\View\Layout $layout;
    protected \ProgramCms\RouterBundle\Service\Request $request;
    protected \Twig\Environment $env;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        \ProgramCms\CoreBundle\View\Layout $layout
    )
    {
        $this->request = $context->getRequest();
        $this->env = $context->getEnvironment();
        $this->layout = $layout;
        $this->_initLayout();
    }

    private function _initLayout()
    {
        $currentRouteName = $this->request->getCurrentRouteName();
        $this->env->render($currentRouteName);
    }

    /**
     * @return \ProgramCms\CoreBundle\View\Layout
     */
    public function getLayout(): \ProgramCms\CoreBundle\View\Layout
    {
        return $this->layout;
    }

    /**
     * Created to override it
     * @param array $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render(array $parameters = []): \Symfony\Component\HttpFoundation\Response{
        // Created to override it
    }
}