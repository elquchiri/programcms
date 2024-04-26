<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class Color
 * @package ProgramCms\UiBundle\Component\Form\Element
 */
class Color extends AbstractElement
{
    const NAME = 'color';

    protected string $_template = "@ProgramCmsUiBundle/form/fields/color.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}