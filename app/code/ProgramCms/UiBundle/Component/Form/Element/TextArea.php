<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class TextArea
 * @package ProgramCms\UiBundle\Component\Form\Element
 */
class TextArea extends AbstractElement
{
    const NAME = 'text';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/textarea.html.twig";

    public function getComponentName()
    {
        return self::NAME;
    }
}