<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Element\Form;

/**
 * Class Form
 * @package ProgramCms\UiBundle\Model\Element
 */
class Form
{
    protected array $fieldSets = [];

    public function __construct()
    {
        $this->fieldSets = [];
    }

    public function addFieldset($fieldset)
    {
        $this->fieldSets[] = $fieldset;
    }

    public function getFieldSets(): array
    {
        return $this->fieldSets;
    }
}