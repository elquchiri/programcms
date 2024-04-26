<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Form\Element;

/**
 * Class File
 * @package ProgramCms\UiBundle\Component\Form\Element
 */
class File extends AbstractElement
{
    const NAME = 'file';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/form/fields/file.html.twig";

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}