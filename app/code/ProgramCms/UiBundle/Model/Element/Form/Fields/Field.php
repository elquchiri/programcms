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
     * @var bool
     */
    protected bool $isRequired = false;

    /**
     * @param $name
     * @return mixed|void
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
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
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $helpMessage
     * @return $this|mixed
     */
    public function setHelpMessage(string $helpMessage)
    {
        $this->helpMessage = $helpMessage;
        return $this;
    }

    /**
     * @return string
     */
    public function getHelpMessage(): string
    {
        return $this->helpMessage;
    }

    /**
     * @param $isRequired
     * @return $this|mixed
     */
    public function setIsRequired($isRequired)
    {
        $this->isRequired = $isRequired;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    /**
     * @return mixed
     */
    abstract public function getHtml(): string;
}