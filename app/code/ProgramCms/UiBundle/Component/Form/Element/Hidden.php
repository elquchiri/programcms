<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class Hidden
 * @package ProgramCms\UiBundle\Block\Form\Fields
 */
class Hidden extends AbstractElement
{
    const NAME = 'field';
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/hidden.html.twig";

    public function getComponentName()
    {
        return self::NAME;
    }
}