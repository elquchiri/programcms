<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Controller\Comment;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\PostBundle\Entity\Comment;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Repository\CommentRepository;
use ProgramCms\PostBundle\Repository\PostRepository;
use ProgramCms\UserBundle\Repository\UserEntityRepository;

/**
 * Class NewController
 * @package ProgramCms\PostBundle\Controller\Comment
 */
class DeleteController extends Controller
{
    /**
     * @var CommentRepository
     */
    protected CommentRepository $commentRepository;

    /**
     * DeleteController constructor.
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
        if($this->getRequest()->getCurrentRequest()->isMethod('POST')) {
            $commentId = $this->getRequest()->getParam('comment_id');
            if(!empty($commentId)) {
                /** @var Comment $comment */
                $comment = $this->commentRepository->getById($commentId);
                $this->commentRepository->remove($comment, true);

                return $this->json([
                    'success' => true,
                    'data' => [
                        'commentId' => $commentId
                    ]
                ]);
            }
        }

        return $this->json([
            'success' => false
        ]);
    }
}