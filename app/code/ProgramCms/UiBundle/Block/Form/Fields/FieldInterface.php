<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Form\Fields;

/**
 * Interface FieldInterface
 * @package ProgramCms\UiBundle\Block\Form\Fields
 */
interface FieldInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param $label
     * @return $this
     */
    public function setLabel($label): static;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param $helpMessage
     * @return $this
     */
    public function setHelpMessage($helpMessage): static;

    /**
     * @return string
     */
    public function getHelpMessage(): string;

    /**
     * @return bool
     */
    public function hasHelpMessage(): bool;

    /**
     * @param $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder): static;

    /**
     * @return string
     */
    public function getPlaceholder(): string;

    /**
     * @return bool
     */
    public function hasPlaceholder(): bool;

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue(mixed $value): static;

    /**
     * @return mixed
     */
    public function getValue(): mixed;
}