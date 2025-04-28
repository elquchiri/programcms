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
 * Class DateColumn
 * @package ProgramCms\UiBundle\Component\Listing\Columns
 */
class DateColumn extends Column
{
    const NAME = 'dateColumn';

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    /**
     * @return string
     */
    protected function _toHtml(): string
    {
        $value = $this->getValue();
        if(!$value instanceof \DateTime) {
            return $value;
        }
        return $value->format('Y-m-d H:i:s');
    }
}