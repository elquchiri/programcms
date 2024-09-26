<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Block;

use Doctrine\Common\Collections\Collection;
use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\FavoriteBundle\Repository\FavoriteRepository;
use ProgramCms\PostBundle\Entity\Comment;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Repository\PostRepository;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Post
 * @package ProgramCms\PostBundle\Block
 */
class Post extends Template
{
    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userEntityRepository;

    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * @var FavoriteRepository
     */
    protected FavoriteRepository $favoriteRepository;

    /**
     * Post constructor.
     * @param Template\Context $context
     * @param PostRepository $postRepository
     * @param Security $security
     * @param UserEntityRepository $userEntityRepository
     * @param CategoryRepository $categoryRepository
     * @param FavoriteRepository $favoriteRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        PostRepository $postRepository,
        Security $security,
        UserEntityRepository $userEntityRepository,
        CategoryRepository $categoryRepository,
        FavoriteRepository $favoriteRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->postRepository = $postRepository;
        $this->security = $security;
        $this->userEntityRepository = $userEntityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->favoriteRepository = $favoriteRepository;
    }

    /**
     * @return PostEntity|null
     */
    public function getPost(): ?PostEntity
    {
        $postId = $this->getRequest()->getParam('id');
        /** @var PostEntity $post */
        $post = $this->postRepository->getById($postId);
        if($post) {
            return $post;
        }
        return null;
    }

    /**
     * @return CategoryEntity|null
     */
    public function getCategory(): ?CategoryEntity
    {
        $categoryId = $this->getRequest()->getParam('category');
        /** @var CategoryEntity $category */
        $category = $this->categoryRepository->getById($categoryId);
        if ($category) {
            return $category;
        }
        return null;
    }

    /**
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->userEntityRepository->getByEmail($this->security->getUser()->getUserIdentifier());
    }

    /**
     * @return UserInterface|null
     */
    public function getSecurityUser(): ?UserInterface
    {
        return $this->security->getUser();
    }

    /**
     * @return string
     */
    public function getCommentSaveUrl(): string
    {
        return $this->getUrl('post_comment_save');
    }

    /**
     * @param Comment $comment
     * @return string
     */
    public function getEditCommentUrl(Comment $comment): string
    {
        return $this->getUrl('post_comment_edit',
            ['category' => $this->getCategory()->getEntityId(), 'comment_id' => $comment->getEntityId()]
        );
    }

    /**
     * @return bool
     */
    public function hasComments(): bool
    {
        return $this->getPost()->getComments()->count() > 0;
    }

    /**
     * @return Collection
     */
    public function getComments(): Collection
    {
        return $this->getPost()->getComments();
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
    public function newPostUrl(): string
    {
        return $this->getUrl('post_index_new', ['category' => $this->getCategory()->getEntityId()]);
    }

    /**
     * @return string
     */
    public function getEditPostUrl(): string
    {
        return $this->getUrl(
            'post_index_edit',
            ['category' => $this->getCategory()->getEntityId(),'post_id' => $this->getPost()->getEntityId()]
        );
    }

    /**
     * @return string
     */
    public function getAddToFavoriteUrl(): string
    {
        return $this->getUrl('favorite_index_new', [
            'category' => $this->getCategory()->getEntityId(),
            'post' => $this->getPost()->getEntityId()
        ]);
    }

    /**
     * @param PostEntity $post
     * @return bool
     */
    public function isPostInFavorite(): bool
    {
        /** @var UserEntity $user */
        $user = $this->getSecurityUser();
        return $this->favoriteRepository->isFavorite($user, $this->getPost());
    }

    /**
     * @param string $fullHtml
     * @return string
     */
    public function formatPost(string $fullHtml): string
    {
        return preg_replace('/<body[^>]*>(.*?)<\/body>/is', '$1', $fullHtml);
    }
}