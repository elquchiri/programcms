<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\FavoriteBundle\Controller\Index;

use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\FavoriteBundle\Entity\Favorite;
use ProgramCms\FavoriteBundle\Repository\FavoriteRepository;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Repository\PostRepository;
use ProgramCms\UserBundle\Entity\UserEntity;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class NewController
 * @package ProgramCms\FavoriteBundle\Controller\Index
 */
class NewController extends Controller
{
    /**
     * @var FavoriteRepository
     */
    protected FavoriteRepository $favoriteRepository;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * NewController constructor.
     * @param Context $context
     * @param FavoriteRepository $favoriteRepository
     * @param PostRepository $postRepository
     * @param CategoryRepository $categoryRepository
     * @param Security $security
     */
    public function __construct(
        Context $context,
        FavoriteRepository $favoriteRepository,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        Security $security
    )
    {
        parent::__construct($context);
        $this->favoriteRepository = $favoriteRepository;
        $this->security = $security;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function execute()
    {
        $postId = $this->getRequest()->getParam('post');
        $categoryId = $this->getRequest()->getParam('category');

        if(empty($postId) || empty($categoryId)) {
            $this->addFlash('danger',
                $this->translator->trans('Cannot add post to your favorite, please try again.')
            );
        }

        /** @var PostEntity $post */
        $post = $this->postRepository->getById($postId);
        /** @var CategoryEntity $category */
        $category = $this->categoryRepository->getById($categoryId);
        /** @var UserEntity $user */
        $user = $this->security->getUser();

        if(!$this->favoriteRepository->isFavorite($user, $post)) {
            $favorite = new Favorite();
            $favorite
                ->setUser($user)
                ->setPost($post)
                ->setCategory($category)
                ->updateTimestamps();
            $this->favoriteRepository->save($favorite);

            $this->addFlash('success',
                $this->translator->trans('The post was successfully added to your favorite.')
            );
        }

        return $this->redirect($this->url->getUrlByRouteName('post_index_view', [
            'category' => $categoryId,
            'id' => $postId
        ]));
    }
}