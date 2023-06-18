<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Form\Fields;

/**
 * Class Text
 * @package ProgramCms\UiBundle\Block\Form\Fields
 */
class TextArea extends \ProgramCms\CoreBundle\View\Element\Template
{
    protected string $_template = "@ProgramCmsUiBundle/form/fields/textarea.html.twig";

    public function getName()
    {
        return $this->getData('name');
    }

    public function getPlaceholder()
    {
        return $this->getData('placeholder');
    }
}