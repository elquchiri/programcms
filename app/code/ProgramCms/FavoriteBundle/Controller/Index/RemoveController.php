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
 * Class RemoveController
 * @package ProgramCms\FavoriteBundle\Controller\Index
 */
class RemoveController extends Controller
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
        $favoriteId = $this->getRequest()->getParam('favorite');

        if(empty($favoriteId)) {
            $this->addFlash('danger',
                $this->translator->trans('Cannot remove post from your favorite, please try again.')
            );
        }
        /** @var Favorite $favorite */
        $favorite = $this->favoriteRepository->getById($favoriteId);
        if($favorite) {
            $this->favoriteRepository->remove($favorite, true);
            $this->addFlash('success',
                $this->translator->trans('The post was successfully removed from your favorite.')
            );
        }

        return $this->redirect($this->url->getUrlByRouteName('favorite_index_index'));
    }
}