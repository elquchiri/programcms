<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Model\Category;

use ProgramCms\CatalogBundle\Model\Collection\Category\Collection;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 * @package ProgramCms\CatalogBundle\Model\Category
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * DataProvider constructor.
     * @param CategoryRepository $categoryRepository
     * @param Collection $collection
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        Collection $collection
    )
    {
        $this->collection = $collection;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return parent::getData();
    }
}