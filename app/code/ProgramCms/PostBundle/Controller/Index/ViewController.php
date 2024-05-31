<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Controller\Index;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
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
     * ViewController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param PostRepository $postRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        PostRepository $postRepository
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->postRepository = $postRepository;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    public function execute()
    {
        $postId = $this->getRequest()->getParam('id');
        $post = $this->postRepository->getById($postId);
        /** @var Page $pageResult */
        $pageResult = $this->objectManager->create(Page::class);
        if($post) {
            $pageResult->getConfig()->getTitle()->set($post->getPostName());
        }
        return $pageResult;
    }
}