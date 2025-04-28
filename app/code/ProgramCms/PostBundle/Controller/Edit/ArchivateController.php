<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Controller\Edit;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Repository\PostRepository;

/**
 * Class ArchivateController
 * @package ProgramCms\PostBundle\Controller\Edit
 */
class ArchivateController extends Controller
{
    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * DisableController constructor.
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
        $postId = $this->getRequest()->getParam('id');
        $categoryId = $this->getRequest()->getParam('category');

        /** @var PostEntity $post */
        $post = $this->postRepository->getById($postId);
        if($post) {
            $post->setPostEnable('on');
            $post->updateTimestamps();
            $this->postRepository->save($post);
            $this->addFlash('success', $this->trans('Post successfully archived.'));
        }

        return $this->redirect($this->getUrl()->getUrlByRouteName('post_index_view', ['id' => $postId, 'category' => $categoryId]));
    }
}