<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Block\Editor;

use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class Editor
 * @package ProgramCms\PostBundle\Block\Editor
 */
class Editor extends Template
{
    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * Editor constructor.
     * @param Template\Context $context
     * @param CategoryRepository $categoryRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CategoryRepository $categoryRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return CategoryEntity
     */
    public function getCategory(): CategoryEntity
    {
        $categoryId = $this->getRequest()->getParam('category');
        return $this->categoryRepository->getById($categoryId);
    }

    /**
     * @return string
     */
    public function getCategoryUrl(): string
    {
        return $this->getUrl('catalog_category_view', ['id' => $this->getCategory()->getEntityId()]);
    }

    /**
     * @return string
     */
    public function getSaveUrl(): string
    {
        return $this->getUrl('post_index_save');
    }

    /**
     * @return bool|string
     */
    public function getJsonData(): bool|string
    {
        return json_encode([
            'category_id' => $this->getCategory()->getEntityId()
        ]);
    }

    /**
     * @return string
     */
    public function getLoadUrl(): string
    {
        return $this->getUrl('post_ajax_loadpost', [
            'post_id' => $this->getPostId()
        ]);
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->getRequest()->getParam('post_id');
    }
}