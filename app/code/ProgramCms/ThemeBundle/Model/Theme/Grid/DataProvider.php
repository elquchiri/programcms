<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Model\Theme\Grid;

use ProgramCms\ThemeBundle\Model\Collection\Theme\Collection;

/**
 * Class DataProvider
 * @package ProgramCms\ThemeBundle\Model\Theme\Grid
 */
class DataProvider extends \ProgramCms\UiBundle\DataProvider\AbstractDataProvider
{
    /**
     * DataProvider constructor.
     * @param Collection $collection
     */
    public function __construct(
        \ProgramCms\ThemeBundle\Model\Collection\Theme\Collection $collection
    )
    {
        $this->collection = $collection;
    }
}