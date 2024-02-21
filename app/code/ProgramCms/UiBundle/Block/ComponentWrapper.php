<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class ComponentWrapper
 * @package ProgramCms\UiBundle\Block
 */
class ComponentWrapper extends Template
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUi/component_wrapper.html.twig";

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getNameInLayout();
    }
}