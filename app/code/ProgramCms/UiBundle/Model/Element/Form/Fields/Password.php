<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Element\Form\Fields;

/**
 * Class Text
 * @package ProgramCms\UiBundle\Model\Element\Form\Fields
 */
class Password extends \ProgramCms\UiBundle\Model\Element\Form\Fields\Field
{
    protected string $placeholder;
    protected \ProgramCms\UiBundle\Block\Form\Fields\Password $password;

    public function __construct(
        \ProgramCms\UiBundle\Block\Form\Fields\Password $password
    )
    {
        $this->password = $password;
    }

    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
    }

    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    public function getHtml(): string
    {
        $this->password->setData([
            "name" => $this->getName(),
            "placeholder" => $this->getPlaceholder()
        ]);

        return $this->password->toHtml();
    }
}