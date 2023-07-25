<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Tabs;

/**
 * Class Tabs
 * @package ProgramCms\UiBundle\Block\Tabs
 */
class Tabs extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUi/tabs/tabs.html.twig";

    /**
     * @return array
     */
    public function getTabs(): array
    {
        return $this->getData();
    }
}