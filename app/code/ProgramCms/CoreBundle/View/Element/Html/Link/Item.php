<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Element\Html\Link;

use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class Item
 * @package ProgramCms\CoreBundle\View\Element\Html\Link
 */
class Item extends Template
{
    /**
     * @return string
     */
    protected function _toHtml(): string
    {
        $label = $this->getLabel();
        $path = $this->getPath();
        $url = $this->getUrl($path);
        return "<a class=\"nav-link active\" href=\"". $url ."\">". $this->trans($label) ."</a>";
    }
}