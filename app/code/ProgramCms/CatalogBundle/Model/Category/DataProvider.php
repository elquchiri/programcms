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

    public function __construct(
        \ProgramCms\CatalogBundle\Repository\CategoryRepository $categoryRepository
    )
    {
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