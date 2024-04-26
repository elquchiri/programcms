<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class Date
 * @package ProgramCms\UiBundle\Component\Form\Element
 */
class Date extends AbstractElement
{
    const NAME = 'date';

    protected string $_template = "@ProgramCmsUiBundle/form/fields/date.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}