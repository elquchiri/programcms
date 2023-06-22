<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Collapser;

/**
 * Class Collapser
 * @package ProgramCms\UiBundle\Block\Collapser
 */
class Collapser extends \ProgramCms\CoreBundle\View\Element\Template
{
    protected string $_template = "@ProgramCmsUiBundle/collapser/collapser.html.twig";

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->hasData('label') ? $this->getData('label') : "";
    }
    /**
     * @return bool
     */
    public function hasLabel(): bool
    {
        return $this->hasData('label');
    }
    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        if(!$this->hasLabel()) {
            return true;
        }
        if($this->hasData('open')) {
            return $this->getData('open');
        }
        return false;
    }
}