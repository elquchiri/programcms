<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Controller\Ajax;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\PostBundle\Entity\Comment;
use ProgramCms\PostBundle\Repository\CommentRepository;

/**
 * Class LoadCommentController
 * @package ProgramCms\PostBundle\Controller\Ajax
 */
class LoadCommentController extends Controller
{
    /**
     * @var CommentRepository
     */
    protected CommentRepository $commentRepository;

    /**
     * LoadCommentController constructor.
     * @param Context $context
     * @param CommentRepository $commentRepository
     */
    public function __construct(
        Context $context,
        CommentRepository $commentRepository
    )
    {
        parent::__construct($context);
        $this->commentRepository = $commentRepository;
    }

    public function execute()
    {
        $commentId = $this->getRequest()->getParam('comment_id');
        if(is_null($commentId) || empty($commentId)) {
            return $this->json([
                'edit' => false
            ]);
        }

        /** @var Comment $comment */
        $comment = $this->commentRepository->getById($commentId);
        return $this->json([
            'edit' => true,
            'data' => $comment->getCommentJson()
        ]);
    }
}