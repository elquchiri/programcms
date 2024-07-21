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
class NewController extends Controller
{
    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userEntityRepository;

    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * @var CommentRepository
     */
    protected CommentRepository $commentRepository;

    /**
     * NewController constructor.
     * @param Context $context
     * @param UserEntityRepository $userEntityRepository
     * @param PostRepository $postRepository
     * @param CommentRepository $commentRepository
     */
    public function __construct(
        Context $context,
        UserEntityRepository $userEntityRepository,
        PostRepository $postRepository,
        CommentRepository $commentRepository
    )
    {
        parent::__construct($context);
        $this->userEntityRepository = $userEntityRepository;
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
    }

    public function execute()
    {
        if($this->getRequest()->getCurrentRequest()->isMethod('POST')) {
            $commentContent = $this->getRequest()->getParam('comment');
            $postId = $this->getRequest()->getParam('post_id');
            if(!empty($commentContent)) {
                $userId = $this->getUser()->getUserIdentifier();
                $user = $this->userEntityRepository->getByEmail($userId);
                /** @var PostEntity $post */
                $post = $this->postRepository->getById($postId);
                $comment = new Comment();
                $comment
                    ->setComment($commentContent)
                    ->setPost($post)
                    ->setUser($user)
                    ->setCreatedAt()
                    ->setUpdatedAt();

                $this->commentRepository->save($comment);
                return $this->json([
                    'success' => true,
                    'data' => [
                        'comment' => $commentContent,
                        'user' => [
                            'fullname' => $user->getFullName(),
                            'image' => $user->getProfileImage()
                        ]
                    ]
                ]);
            }
        }

        return $this->json([
            'success' => false
        ]);
    }
}