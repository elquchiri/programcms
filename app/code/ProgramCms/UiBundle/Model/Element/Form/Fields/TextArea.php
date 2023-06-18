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
class TextArea extends \ProgramCms\UiBundle\Model\Element\Form\Fields\Field
{
    protected string $placeholder;
    protected \ProgramCms\UiBundle\Block\Form\Fields\TextArea $textArea;

    public function __construct(
        \ProgramCms\UiBundle\Block\Form\Fields\TextArea $textArea
    )
    {
        $this->textArea = $textArea;
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
        $this->textArea->setData([
            "name" => $this->getName(),
            "placeholder" => $this->getPlaceholder()
        ]);

        return $this->textArea->toHtml();
    }
}