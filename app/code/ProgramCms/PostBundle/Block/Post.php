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
use ProgramCms\CoreBundle\DateTime\TransformerInterface;
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
     * @var TransformerInterface
     */
    protected TransformerInterface $transformer;

    /**
     * Post constructor.
     * @param Template\Context $context
     * @param PostRepository $postRepository
     * @param Security $security
     * @param UserEntityRepository $userEntityRepository
     * @param CategoryRepository $categoryRepository
     * @param FavoriteRepository $favoriteRepository
     * @param TransformerInterface $transformer
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        PostRepository $postRepository,
        Security $security,
        UserEntityRepository $userEntityRepository,
        CategoryRepository $categoryRepository,
        FavoriteRepository $favoriteRepository,
        TransformerInterface $transformer,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->postRepository = $postRepository;
        $this->security = $security;
        $this->userEntityRepository = $userEntityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->favoriteRepository = $favoriteRepository;
        $this->transformer = $transformer;
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
     * @return string
     */
    public function getUserUrl(): string
    {
        return $this->getUrl('user_profile_view', ['id' => $this->getPost()->getUser()->getEntityId()]);
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
     * @return int
     */
    public function countComments(): int
    {
        return  $this->getComments()->count();
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
        if(!$user) {
            return false;
        }
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

    /**
     * @return string
     */
    public function getPostUpdatedAt(): string
    {
        return $this->transformer->timeAgo($this->getPost()->getUpdatedAt());
    }

    /**
     * @param Comment $comment
     * @return string
     */
    public function getCommentUpdatedAt(Comment $comment): string
    {
        return $this->transformer->timeAgo($comment->getUpdatedAt());
    }

    public function getUserGroups()
    {
        $user = $this->getPost()->getUser();
        $groups = "";
        foreach($user->getCollectionGroups() as $group) {
            $groups .= "<p class='m-0' style='font-size: 15px; color: {$group->getColor()}'>" . $this->trans($group->getName()) . "</p>";
        }
        return $groups;
    }

    /**
     * @param PostEntity $post
     * @return string
     */
    public function getPinUrl(): string
    {
        $post = $this->getPost();
        $category = $this->getCategory();
        return $this->getUrl('post_edit_pin', ['id' => $post->getEntityId(), 'category' => $category->getEntityId()]);
    }

    public function getLockUrl(): string
    {
        $post = $this->getPost();
        $category = $this->getCategory();
        return $this->getUrl('post_edit_lock', ['id' => $post->getEntityId(), 'category' => $category->getEntityId()]);
    }

    public function getDisableUrl(): string
    {
        $post = $this->getPost();
        $category = $this->getCategory();
        return $this->getUrl('post_edit_disable', ['id' => $post->getEntityId(), 'category' => $category->getEntityId()]);
    }

    /**
     * @return bool
     */
    public function canComment(): bool
    {
        return $this->getPost()->getPostLock() !== 'on';
    }

    /**
     * @return Collection
     */
    public function getRelatedPosts(): Collection
    {
        return $this->getPost()->getUser()->getPosts();
    }

    /**
     * @return bool
     */
    public function hasRelatedPosts(): bool
    {
        return !empty($this->getRelatedPosts());
    }

    /**
     * @return string
     */
    public function getPosterFlag(): string
    {
        $countryCode = $this->getPost()->getUser()->getDefaultAddress()->getCountryCode();
        return '/bundles/programcmswebsite/images/flags/' . strtolower($countryCode) . '.png';
    }
}