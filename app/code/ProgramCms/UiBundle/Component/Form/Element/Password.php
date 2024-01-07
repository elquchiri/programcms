<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class Password
 * @package ProgramCms\UiBundle\Component\Form\Element
 */
class Password extends AbstractElement
{
    const NAME = 'password';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/password.html.twig";

    public function getComponentName()
    {
        return self::NAME;
    }
}