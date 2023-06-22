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
class Page
{

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context
    )
    {
        $this->pageConfig = $context->getPageConfig();
    }

    /**
     * Get Page Configuration
     */
    public function getConfig()
    {
        return $this->pageConfig;
    }
}