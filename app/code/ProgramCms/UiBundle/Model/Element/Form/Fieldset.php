<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Element\Form;

/**
 * Class Fieldset
 * @package ProgramCms\UiBundle\Model\Element\Form
 */
class Fieldset
{
    protected array $fields = [];

    public function __construct()
    {
        $this->fields = [];
    }

    public function addField($field)
    {
        $this->fields[] = $field;
    }

    public function getFields(): array
    {
        return $this->fields;
    }
}