<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Block\Page;

use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class Current
 * @package ProgramCms\ThemeBundle\Block\Page
 */
class Current extends Template
{
    /**
     * @return string
     */
    protected function _toHtml(): string
    {
        $label = $this->trans($this->getData('label'));
        $url = $this->getData('path');

        return "<li><a href=\"{$url}\">{$label}</a></li>";
    }
}