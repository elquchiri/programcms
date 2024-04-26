<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class Switcher
 * @package ProgramCms\UiBundle\Component\Form\Element
 */
class Switcher extends AbstractElement
{
    const NAME = 'switcher';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/switcher.html.twig";

    /**
     * @return bool
     */
    public function isChecked(): bool
    {
        return $this->hasData('value') && in_array($this->getValue(), ['on', 1, true]);
    }

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}