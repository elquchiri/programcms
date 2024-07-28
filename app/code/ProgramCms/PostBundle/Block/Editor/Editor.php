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
        return $this->isPostMode() ? $this->getUrl('post_index_save') : $this->getUrl('post_comment_save');
    }

    /**
     * @return int|null
     */
    public function getPostId()
    {
        return $this->getRequest()->hasParam('post_id') ? $this->getRequest()->getParam('post_id') : null;
    }

    public function getSaveCommentUrl(): string
    {
        return $this->getUrl('post_comment_save');
    }

    /**
     * @return bool
     */
    public function isPostMode(): bool
    {
        return in_array($this->getRequest()->getCurrentRouteName(), ['post_index_edit', 'post_index_new']);
    }

    /**
     * @return bool
     */
    public function isCommentMode(): bool
    {
        return in_array($this->getRequest()->getCurrentRouteName(), ['post_comment_edit']);
    }

    /**
     * @return string
     */
    public function getEditorMode(): string
    {
        return $this->isPostMode() ? 'post' : 'comment';
    }

    /**
     * @return mixed
     */
    public function getCommentId()
    {
        return $this->getRequest()->getParam('comment_id');
    }
}