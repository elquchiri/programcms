<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Model\Provider\DataSource\Category;


use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\UiBundle\Model\Provider\DataSource\Options;

/**
 * Class Categories
 * @package ProgramCms\PostBundle\Model\Provider\DataSource\Category
 */
class Categories extends Options
{
    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * RootCategories constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get All Categories
     * @return array
     */
    public function getOptionsArray(): array
    {
        $categoriesData = [];
        $categories = $this->categoryRepository->findAll();
        /** @var CategoryEntity $category */
        foreach($categories as $category) {
            $categoriesData[$category->getEntityId()] = $category->getCategoryName();
        }
        return $categoriesData;
    }
}