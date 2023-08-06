<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Model\Category;

/**
 * Class DataProvider
 * @package ProgramCms\CatalogBundle\Model\Category
 */
class DataProvider extends \ProgramCms\UiBundle\DataProvider\AbstractDataProvider
{
    /**
     * @var \ProgramCms\CatalogBundle\Repository\CategoryRepository
     */
    protected \ProgramCms\CatalogBundle\Repository\CategoryRepository $categoryRepository;

    /**
     * DataProvider constructor.
     * @param \ProgramCms\CatalogBundle\Repository\CategoryRepository $categoryRepository
     * @param \ProgramCms\CatalogBundle\Model\Collection\Category\Collection $collection
     */
    public function __construct(
        \ProgramCms\CatalogBundle\Repository\CategoryRepository $categoryRepository,
        \ProgramCms\CatalogBundle\Model\Collection\Category\Collection $collection
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