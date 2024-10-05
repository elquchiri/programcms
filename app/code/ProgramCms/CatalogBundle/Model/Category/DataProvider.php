<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Model\Category;

use ProgramCms\CatalogBundle\Model\Collection\Category\Collection;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 * @package ProgramCms\CatalogBundle\Model\Category
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * DataProvider constructor.
     * @param Collection $collection
     */
    public function __construct(
        Collection $collection
    )
    {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return parent::getData();
    }
}