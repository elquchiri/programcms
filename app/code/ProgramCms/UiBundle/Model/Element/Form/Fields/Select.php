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

    public function __construct(
        \ProgramCms\UiBundle\Block\Form\Fields\Select $select
    )
    {
        $this->select = $select;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getHtml(): string
    {
        $this->select->setData([
            "name" => $this->getName(),
            "options" => $this->getOptions()
        ]);

        return $this->select->toHtml();
    }
}