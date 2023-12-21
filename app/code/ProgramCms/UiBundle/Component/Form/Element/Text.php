<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class Text
 * @package ProgramCms\UiBundle\Component\Form\Element
 */
class Text extends AbstractElement
{
    const NAME = 'text';

    protected string $_template = "@ProgramCmsUiBundle/form/fields/text.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}