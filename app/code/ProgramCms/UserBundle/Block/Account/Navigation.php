<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block\Account;

use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class Navigation
 * @package ProgramCms\UserBundle\Block\Account
 */
class Navigation extends Template
{
    /**
     * @return string
     */
    public function generateMenu(): string
    {
        $html = "";
        $items = $this->getChildBlocks();
        uasort($items, function ($firstItem, $secondItem) {
            return $firstItem->getData('sortOrder') <=> $secondItem->getData('sortOrder');
        });
        foreach($items as $child) {
            $html .= $child->toHtml();
        }

        return $html;
    }
}