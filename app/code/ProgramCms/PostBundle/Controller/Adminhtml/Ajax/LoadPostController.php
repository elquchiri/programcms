<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Controller\Adminhtml\Ajax;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Repository\PostRepository;

/**
 * Class LoadPostController
 * @package ProgramCms\PostBundle\Controller\Adminhtml\Ajax
 */
class LoadPostController extends AdminController
{
    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * LoadPostController constructor.
     * @param Context $context
     * @param PostRepository $postRepository
     */
    public function __construct(
        Context $context,
        PostRepository $postRepository
    )
    {
        parent::__construct($context);
        $this->postRepository = $postRepository;
    }

    public function execute()
    {
        $postId = $this->getRequest()->getParam('post_id');
        if(is_null($postId) || empty($postId)) {
            return $this->json([
                'edit' => false
            ]);
        }

        /** @var PostEntity $post */
        $post = $this->postRepository->getById($postId);
        return $this->json([
            'edit' => true,
            'title' => $post->getPostName(),
            'data' => $post->getPostContent()
        ]);
    }
}