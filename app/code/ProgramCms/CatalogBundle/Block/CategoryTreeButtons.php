<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Block;

use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;

/**
 * Class CategoryTreeButtons
 * @package ProgramCms\CatalogBundle\Block
 */
class CategoryTreeButtons extends Template
{
    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * CategoryTreeButtons constructor.
     * @param Template\Context $context
     * @param CategoryRepository $categoryRepository
     * @param Url $url
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CategoryRepository $categoryRepository,
        Url $url,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->categoryRepository = $categoryRepository;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getNewRootCategoryUrl(): string
    {
        $category = $this->categoryRepository->getRootCategory();
        return $this->url->getUrlByRouteName('catalog_category_add', ['parent' => $category->getEntityId()]);
    }

    /**
     * @return string
     */
    public function getNewSubCategoryUrl(): string
    {
        $categoryId = $this->getRequest()->getParam('id');
        return $this->url->getUrlByRouteName('catalog_category_add', ['parent' => $categoryId]);
    }
}