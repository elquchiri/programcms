<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Form\Fields;

/**
 * Class Field
 * @package ProgramCms\UiBundle\Block\Form\Fields
 */
abstract class Field extends \ProgramCms\CoreBundle\View\Element\Template implements FieldInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getNameInLayout();
    }

    /**
     * @param $label
     * @return $this
     */
    public function setLabel($label): static
    {
        $this->setData('label', $label);
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->getData('label');
    }

    /**
     * @return bool
     */
    public function hasLabel(): bool
    {
        return $this->hasData('label') && !empty($this->getData('label'));
    }

    /**
     * @param $helpMessage
     * @return $this
     */
    public function setHelpMessage($helpMessage): static
    {
        $this->setData('helpMessage', $helpMessage);
        return $this;
    }

    /**
     * @return string
     */
    public function getHelpMessage(): string
    {
        return $this->getData('helpMessage');
    }

    /**
     * @return bool
     */
    public function hasHelpMessage(): bool
    {
        return $this->hasData('helpMessage');
    }

    /**
     * @param $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder): static
    {
        $this->setData('placeholder', $placeholder);
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceholder(): string
    {
        return $this->getData('placeholder');
    }

    /**
     * @return bool
     */
    public function hasPlaceholder(): bool
    {
        return $this->hasData('placeholder');
    }

    /**
     * Set Field Value
     * Can be overridden in child classes
     * @param mixed $value
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        $this->setData('value', $value);
        return $this;
    }

    /**
     * Get Field Value
     * Can be overridden in child classes
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->getData('value');
    }

    /**
     * @param $isRequired
     * @return $this
     */
    public function setIsRequired(bool $isRequired): static
    {
        $this->setData('isRequired', $isRequired);
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->hasData('isRequired') ? $this->getData('isRequired') : false;
    }

    /**
     * @param bool $isVisible
     * @return $this|Field
     */
    public function setIsVisible(bool $isVisible): static
    {
        $this->setData('isVisible', $isVisible);
        return $this;
    }

    /**
     * Visible by default
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->hasData('isVisible') ? $this->getData('isVisible') : true;
    }
}