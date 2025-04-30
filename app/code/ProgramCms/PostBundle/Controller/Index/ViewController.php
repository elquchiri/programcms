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
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Model\PostViewRecorder;
use ProgramCms\PostBundle\Repository\PostRepository;
use ReflectionException;

/**
 * Class ViewController
 * @package ProgramCms\PostBundle\Controller\Index
 */
class ViewController extends Controller
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
     * @var PostViewRecorder
     */
    protected PostViewRecorder $postViewRecorder;

    /**
     * ViewController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param PostRepository $postRepository
     * @param CategoryRepository $categoryRepository
     * @param PostViewRecorder $postViewRecorder
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        PostViewRecorder $postViewRecorder
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->postViewRecorder = $postViewRecorder;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    public function execute()
    {
        $postId = $this->getRequest()->getParam('id');
        $categoryId = $this->getRequest()->getParam('category');

        /** @var PostEntity $post */
        $post = $this->postRepository->getById($postId);

        /** @var Page $pageResult */
        $pageResult = $this->objectManager->create(Page::class);
        if($post) {
            $pageResult->getConfig()->getTitle()->set($post->getPostName());

            /** @var CategoryEntity $category */
            $category = $this->categoryRepository->getById($categoryId);
            if($category) {
                $pageResult->getConfig()->getBreadcrumb()->add([
                    'label' => $category->getCategoryName(),
                    'url' => ''
                ]);
            }

            $pageResult->getConfig()->getBreadcrumb()->add([
                'label' => $post->getPostName(),
                'url' => ''
            ]);

            // Record Post View
            $this->postViewRecorder->record($post);
        }
        return $pageResult;
    }
}