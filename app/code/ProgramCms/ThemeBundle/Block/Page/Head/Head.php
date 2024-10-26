<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Block\Page\Head;

use Exception;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\ThemeBundle\Webpack\Output;

/**
 * Class Head
 * @package ProgramCms\ThemeBundle\Block\Page\Head
 */
class Head extends Template
{
    /**
     * @var Output
     */
    protected Output $webpackOutput;

    /**
     * Head constructor.
     * @param Template\Context $context
     * @param Output $webpackOutput
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Output $webpackOutput,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->webpackOutput = $webpackOutput;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getAppCss(): string
    {
        return $this->webpackOutput->getCss();
    }

    /**
     * @return array
     */
    public function getStaticCss()
    {
        return $this->getLayout()->getCss();
    }
}