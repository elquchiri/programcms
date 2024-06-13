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
     * SaveController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param PostRepository $postRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return JsonResponse
     */
    public function execute()
    {
        $editorJson = $this->getRequest()->getParam('post_content');
        $postTitle = $this->getRequest()->getParam('post_title');
        $postHtml = $this->getRequest()->getParam('post_html');
        $postCss = $this->getRequest()->getParam('post_css');
        $categoryId = $this->getRequest()->getParam('category_id');
        /** @var CategoryEntity $category */
        $category = $this->categoryRepository->getById($categoryId);
        $post = new PostEntity();
        $post
            ->addCategory($category)
            ->setPostName($postTitle)
            ->setPostContent($editorJson)
            ->setPostHtml($postHtml)
            ->setPostCss($postCss)
            ->setCreatedAt()
            ->setUpdatedAt();

        // Save Post
        $this->postRepository->save($post);

        return $this->json([
            'success' => true,
            'title' => $postTitle
        ]);
    }
}