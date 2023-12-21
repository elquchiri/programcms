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
 * @package ProgramCms\UiBundle\Block\Form\Fields
 */
class TextArea extends AbstractElement
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/textarea.html.twig";

    public function getComponentName()
    {
        // TODO: Implement getComponentName() method.
    }
}