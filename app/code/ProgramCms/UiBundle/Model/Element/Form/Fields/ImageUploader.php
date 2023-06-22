<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Element\Form\Fields;

/**
 * Class ImageUploader
 * @package ProgramCms\UiBundle\Model\Element\Form\Fields
 */
class ImageUploader extends \ProgramCms\UiBundle\Model\Element\Form\Fields\Field
{
    protected string $placeholder;
    protected \ProgramCms\UiBundle\Block\Form\Fields\ImageUploader $imageUploader;

    public function __construct(
        \ProgramCms\UiBundle\Block\Form\Fields\ImageUploader $imageUploader
    )
    {
        $this->imageUploader = $imageUploader;
    }

    public function getHtml(): string
    {
        $this->imageUploader->setData([
            "name" => $this->getName()
        ]);

        return $this->imageUploader->toHtml();
    }
}