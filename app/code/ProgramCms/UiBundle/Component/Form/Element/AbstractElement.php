<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;


use ProgramCms\UiBundle\Block\Form\Fields\Field;
use ProgramCms\UiBundle\Component\AbstractComponent;

/**
 * Class AbstractElement
 * @package ProgramCms\UiBundle\Component\Form\Element
 */
abstract class AbstractElement extends AbstractComponent
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->hasData('name') ? $this->getData('name') : $this->getNameInLayout();
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->setData('name', $name);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->hasData('id') ? $this->getData('id') : $this->getName();
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
        return $this->trans($this->getData('label'));
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
        return $this->trans($this->getData('helpMessage'));
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
        return $this->trans($this->getData('placeholder'));
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

    /**
     * @param string $scope
     * @return $this
     */
    public function setScope(string $scope): static
    {
        $this->setData('scope', $scope);
        return $this;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->hasData('scope') ? $this->getData('scope') : '';
    }

    /**
     * @return bool
     */
    public function isInheritCheckboxRequired(): bool
    {
        return (
                $this->hasData('canUseDefaultValue')
                && $this->hasData('canUseWebsiteValue')
                && $this->hasData('canRestoreToDefault')
            ) &&
            ($this->getData('canUseDefaultValue')
                || $this->getData('canUseWebsiteValue')
                || $this->getData('canRestoreToDefault'));
    }

    /**
     * @return string
     */
    protected function _getInheritCheckboxLabel(): string
    {
        $checkboxLabel = 'Use system value';
        if ($this->getData('canUseDefaultValue')) {
            $checkboxLabel = 'Use Default';
        }
        if ($this->getData('canUseWebsiteValue')) {
            $checkboxLabel = 'Use Website';
        }
        return $this->trans($checkboxLabel);
    }

    public function setScopeLabel(string $label)
    {
        $this->setData('scopeLabel', $label);
        return $this;
    }

    /**
     * @return string
     */
    public function getScopeLabel(): string
    {
        return $this->hasData('scopeLabel') ? $this->getData('scopeLabel') : '';
    }

    /**
     * @param $isDisabled
     * @return $this
     */
    public function setIsDisabled($isDisabled): static
    {
        $this->setData('disabled', $isDisabled);
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return ($this->isInherit() && $this->isInheritCheckboxRequired())
            || ($this->hasData('disabled') && $this->getData('disabled'));
    }

    /**
     * @return bool
     */
    public function isInherit(): bool
    {
        return $this->hasData('inherit') ? $this->getData('inherit') : false;
    }

    /**
     * @return array|false|mixed
     */
    public function getIsDisableInheritance()
    {
        return $this->hasData('is_disable_inheritance') ? $this->getData('is_disable_inheritance') : false;
    }

    /**
     * @return string
     */
    public function renderInheritCheckbox(): string
    {
        $name = $this->getName();
        $id = $this->getId();
        $namePrefix = preg_replace('#\[value\](\[\])?$#', '', $name);
        $inheritCheckboxLabel = $this->_getInheritCheckboxLabel();
        $checkedHtml = $this->isInherit() ? 'checked="checked"' : '';
        $disabled = $this->getIsDisableInheritance() == true ? ' disabled="disabled" readonly="1"' : '';

        $content = <<<HTML
            <div class="mt-2 form-check">
                <input type="checkbox" class="form-check-input" name="{$namePrefix}[inherit]"
                    id="{$id}_inherit" value="1" data-controller="inherit-checkbox" data-action="inherit-checkbox#inheritCheckboxClick" $disabled $checkedHtml>
                <label class="form-check-label" for="{$id}_inherit"
                    style="font-size: 14px;">
                    $inheritCheckboxLabel
                </label>
            </div>
HTML;
        return $content;
    }
}