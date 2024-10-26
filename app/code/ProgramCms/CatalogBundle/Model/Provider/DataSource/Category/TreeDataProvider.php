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
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use ProgramCms\CatalogBundle\Model\Collection\Category\Collection;

/**
 * Class TreeDataProvider
 * @package ProgramCms\CatalogBundle\Model\Provider\DataSource\Category
 */
class TreeDataProvider extends AbstractDataProvider
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * TreeDataProvider constructor.
     * @param Collection $collection
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @param Url $url
     */
    public function __construct(
        Collection $collection,
        CategoryRepository $categoryRepository,
        Request $request,
        Url $url
    )
    {
        $this->collection = $collection;
        $this->request = $request;
        $this->url = $url;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $tree = [];
        /** @var CategoryEntity $rootCategory */
        $rootCategory = $this->categoryRepository->getRootCategory();
        foreach($rootCategory->getChildren() as $child) {
            $tree[] = $this->buildCategoryTree($child);
        }
        return $tree;
    }

    /**
     * @param CategoryEntity $category
     * @return array
     */
    private function buildCategoryTree(CategoryEntity $category): array {
        $tree = [
            'label' => $category->getCategoryName(),
            'is_active' => (int) $this->request->getParam('id') === $category->getEntityId(),
            'count' => $category->getChildren()->count(),
            'url' => $this->url->getUrlByRouteName('catalog_category_edit', ['id' => $category->getEntityId()]),
            'children' => []
        ];

        if($category->hasChildren()) {
            foreach ($category->getChildren() as $child) {
                $tree['children'][$child->getEntityId()] = $this->buildCategoryTree($child);
            }
        }

        return $tree;
    }
}