<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing\Columns;

use ProgramCms\UiBundle\Component\Listing\Column;

/**
 * Class ImageColumn
 * @package ProgramCms\UiBundle\Component\Listing\Columns
 */
class ImageColumn extends Column
{
    const NAME = 'imageColumn';

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    protected function _toHtml(): string
    {
        return "<img src='{$this->getValue()}' class='{$this->getData('htmlClass')}' />";
    }
}