<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class PlainText
 * @package ProgramCms\UiBundle\Block\Form\Fields
 */
class PlainText extends AbstractElement
{
    const NAME = 'plainText';
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/plain_text.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}