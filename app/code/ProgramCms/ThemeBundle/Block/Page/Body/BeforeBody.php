<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Block\Page\Body;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\ThemeBundle\Webpack\Output;

/**
 * Class BeforeBody
 * @package ProgramCms\ThemeBundle\Block\Page\Body
 */
class BeforeBody extends Template
{
    /**
     * @var Output
     */
    protected Output $webpackOutput;

    /**
     * BeforeBody constructor.
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
     * @throws \Exception
     */
    public function getAppJs(): string
    {
        return $this->webpackOutput->getJs();
    }

    /**
     * @return array
     */
    public function getStaticJs()
    {
        return $this->getLayout()->getJs();
    }
}