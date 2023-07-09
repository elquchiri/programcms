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
class Select extends \ProgramCms\UiBundle\Block\Form\Fields\Field
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/select.html.twig";

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->getData('options');
    }

    /**
     * @return bool
     */
    public function isMultiSelect(): bool
    {
        return $this->hasData('multiSelect') && $this->getData('multiSelect');
    }

    /**
     * @param $multiSelect
     * @return $this
     */
    public function setMultiSelect($multiSelect): static
    {
        $this->setData('multiSelect', true);
        return $this;
    }
}