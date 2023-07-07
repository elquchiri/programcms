<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Element\Form\Fields;

/**
 * Class Select
 * @package ProgramCms\UiBundle\Model\Element\Form\Fields
 */
class Select extends \ProgramCms\UiBundle\Model\Element\Form\Fields\Field
{

    protected \ProgramCms\UiBundle\Block\Form\Fields\Select $select;
    private array $options;
    private bool $isMultiSelect = false;

    public function __construct(
        \ProgramCms\UiBundle\Block\Form\Fields\Select $select
    )
    {
        $this->select = $select;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param $multiSelect
     */
    public function setMultiSelect($multiSelect)
    {
        $this->isMultiSelect = true;
    }

    /**
     * @return bool
     */
    public function isMultiSelect(): bool
    {
        return $this->isMultiSelect;
    }

    public function getHtml(): string
    {
        $this->select->setData([
            "name" => $this->getName(),
            "options" => $this->getOptions(),
            "isMultiSelect" => $this->isMultiSelect()
        ]);

        return $this->select->toHtml();
    }
}