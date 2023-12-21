<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class ImageUploader
 * @package ProgramCms\UiBundle\Block\Form\Fields
 */
class ImageUploader extends AbstractElement
{
    const NAME = 'image_uploader';
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/image_uploader.html.twig";

    public function getComponentName()
    {
        return self::NAME;
    }
}