<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class Editor
 * @package ProgramCms\UiBundle\Component\Form\Element
 */
class Editor extends AbstractElement
{
    const NAME = 'editor';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/editor.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}