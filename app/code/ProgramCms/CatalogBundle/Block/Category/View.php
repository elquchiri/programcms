<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Block\Category;

use Doctrine\Common\Collections\Collection;
use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\RouterBundle\Service\Url;

/**
 * Class View
 * @package ProgramCms\CatalogBundle\Block\Category
 */
class View extends Template
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
     * View constructor.
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
     * @return CategoryEntity|null
     */
    public function getCategory(): ?CategoryEntity
    {
        $id = $this->getRequest()->getParam('id');
        /** @var CategoryEntity $category */
        $category = $this->categoryRepository->getById($id);
        if ($category) {
            return $category;
        }
        return null;
    }

    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return $this->getCategory()->getPosts();
    }

    /**
     * @param PostEntity $post
     * @return string
     */
    public function getPostUrl(PostEntity $post): string
    {
        return $this->url->getUrlByRouteName('post_index_view', ['id' => $post->getEntityId()]);
    }

    /**
     * @return bool
     */
    public function hasPosts(): bool
    {
        return (bool) $this->getCategory()->getPosts()->count();
    }

    /**
     * @return string
     */
    public function newPostUrl(): string
    {
        return $this->url->getUrlByRouteName('post_index_new', ['category' => $this->getCategory()->getEntityId()]);
    }
}