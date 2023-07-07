<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Form\Fields;

/**
 * Class Select
 * @package ProgramCms\UiBundle\Block\Form\Fields
 */
class Select extends \ProgramCms\CoreBundle\View\Element\Template
{
    protected string $_template = "@ProgramCmsUiBundle/form/fields/select.html.twig";

    public function getName()
    {
        return $this->getData('name');
    }

    public function getOptions()
    {
        return $this->getData('options');
    }

    public function isMultiSelect()
    {
        return $this->getData('isMultiSelect');
    }
}