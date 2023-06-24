<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Block\Html;

/**
 * Class Title
 * @package ProgramCms\ThemeBundle\Block\Html
 */
class Title extends \ProgramCms\CoreBundle\View\Element\Template
{

    /**
     * @return string
     */
    public function getPageTitle(): string
    {
        return $this->pageConfig->getTitle()->get();
    }
}