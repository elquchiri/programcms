<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Element\Form\Fields;

/**
 * Class Switcher
 * @package ProgramCms\UiBundle\Model\Element\Form\Fields
 */
class Switcher extends \ProgramCms\UiBundle\Model\Element\Form\Fields\Field
{
    protected string $placeholder = "";
    protected \ProgramCms\UiBundle\Block\Form\Fields\Switcher $switcher;

    public function __construct(
        \ProgramCms\UiBundle\Block\Form\Fields\Switcher $switcher
    )
    {
        $this->switcher = $switcher;
    }

    public function getHtml(): string
    {
        $this->switcher->setData([
            "name" => $this->getName()
        ]);

        return $this->switcher->toHtml();
    }
}