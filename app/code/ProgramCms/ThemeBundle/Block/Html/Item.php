<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Block\Html;

/**
 * Class Item
 * @package ProgramCms\ThemeBundle\Block\Html
 */
class Item extends \ProgramCms\CoreBundle\View\Element\Html\Link\Item
{
    /**
     * @return string
     */
    protected function _toHtml(): string
    {
        $label = $this->getLabel();
        $path = $this->getPath();
        $url = $this->getUrl($path);
        $currentRouteName = $this->url->getRouteName();
        $isActive = $currentRouteName === $path ? 'active' : '';
        return "<li><a class=\"$isActive\" href=\"". $url ."\">". $this->trans($label) ."</a></li>";
    }
}