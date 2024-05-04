<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Model\Provider\DataSource\Category;

use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\UiBundle\Model\Provider\DataSource\Options;

/**
 * Class RootCategories
 * @package ProgramCms\CatalogBundle\Model\Provider\DataSource\Category
 */
class RootCategories extends Options
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
     * Get Root Categories
     * @return array
     */
    public function getOptionsArray(): array
    {
        $categories = [];
        $rootCategory = $this->categoryRepository->getRootCategory();
        /** @var CategoryEntity $child */
        foreach($rootCategory->getChildren() as $child) {
            $categories[$child->getEntityId()] = $child->getCategoryName();
        }
        return $categories;
    }
}