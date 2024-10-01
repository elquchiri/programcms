<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Controller\Index;

use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Repository\PostRepository;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SaveController
 * @package ProgramCms\PostBundle\Controller\Index
 */
class SaveController extends Controller
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * @var CategoryRepository 
     */
    protected CategoryRepository $categoryRepository;

    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param PostRepository $postRepository
     * @param CategoryRepository $categoryRepository
     * @param UserEntityRepository $userRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        UserEntityRepository $userRepository
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @return JsonResponse
     */
    public function execute()
    {
        $postId = $this->getRequest()->getParam('post_id');
        $editorJson = $this->getRequest()->getParam('post_data');
        $postTitle = $this->getRequest()->getParam('post_title');
        $postHtml = $this->getRequest()->getParam('post_html');
        $postCss = $this->getRequest()->getParam('post_css');
        $categoryId = $this->getRequest()->getParam('category_id');

        if(empty($postTitle)) {
            return $this->json([
                'success' => false,
                'message' => $this->trans('Please give a title to the topic.')
            ]);
        }

        // Prepare Post
        if(!is_null($postId) && !empty($postId)) {
            $post = $this->postRepository->getById($postId);
        }else{
            /** @var CategoryEntity $category */
            $category = $this->categoryRepository->getById($categoryId);
            $userId = $this->getUser()->getUserIdentifier();
            $user = $this->userRepository->getByEmail($userId);
            $post = new PostEntity();
            $post
                ->addCategory($category)
                ->setUser($user)
                ->setCreatedAt();
        }
        $post
            ->setPostName($postTitle)
            ->setPostContent($editorJson)
            ->setPostHtml($postHtml)
            ->setPostCss($postCss)
            ->setUpdatedAt();

        // Save Post
        $this->postRepository->save($post);

        return $this->json([
            'success' => true,
            'redirect_url' => $this->getPostUrl($categoryId, $post->getEntityId())
        ]);
    }

    /**
     * @param $category
     * @param $post
     * @return string
     */
    public function getPostUrl($category, $post): string
    {
        return $this->getUrl()->getUrl('post_index_view', ['category' => $category, 'id' => $post]);
    }
}