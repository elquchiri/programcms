<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Element\Form\Fields;

/**
 * Interface FieldInterface
 * @package ProgramCms\UiBundle\Model\Element\Form\Fields
 */
interface FieldInterface
{
    /**
     * @param $name
     * @return mixed
     */
    public function setName(string $name);
    /**
     * @return string
     */
    public function getName(): string;
    /**
     * @param $value
     * @return mixed
     */
    public function setLabel($label);

    /**
     * @return mixed
     */
    public function getLabel(): string;

    /**
     * @return mixed
     */
    public function setHelpMessage(string $helpMessage);

    /**
     * @return string
     */
    public function getHelpMessage(): string;

    /**
     * @return mixed
     */
    public function getHtml();
}