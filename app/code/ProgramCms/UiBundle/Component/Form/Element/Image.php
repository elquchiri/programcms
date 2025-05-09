<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class Image
 * @package ProgramCms\UiBundle\Block\Form\Fields
 */
class Image extends AbstractElement
{
    const NAME = 'image';
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/image.html.twig";

    /**
     * Prepare Image source path
     * @return string
     */
    public function getSrc(): string
    {
        return $this->hasValue() ? $this->getValue() : '';
    }

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}