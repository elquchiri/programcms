<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Element\Form\Fields;

/**
 * Class Field
 * @package ProgramCms\UiBundle\Model\Element\Form\Fields
 */
abstract class Field implements FieldInterface
{
    /**
     * @var string
     */
    protected string $name;
    /**
     * @var string
     */
    protected string $label;
    /**
     * @var string
     */
    protected string $helpMessage = "";

    /**
     * @param $name
     * @return mixed|void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $label
     * @return mixed|void
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    public function setHelpMessage(string $helpMessage)
    {
        $this->helpMessage = $helpMessage;
    }

    public function getHelpMessage(): string
    {
        return $this->helpMessage;
    }

    /**
     * @return mixed
     */
    abstract public function getHtml(): string;
}