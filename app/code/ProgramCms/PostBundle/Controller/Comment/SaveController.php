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
 * Class SaveController
 * @package ProgramCms\PostBundle\Controller\Comment
 */
class SaveController extends Controller
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
            $commentId = $this->getRequest()->getParam('comment_id');
            $commentContent = $this->getRequest()->getParam('comment');
            $postId = $this->getRequest()->getParam('post_id');
            if(!empty($commentContent)) {
                $userId = $this->getUser()->getUserIdentifier();
                $user = $this->userEntityRepository->getByEmail($userId);

                if(!is_null($commentId) && !empty($commentId)) {
                    $commentJson = $this->getRequest()->getParam('comment_data');
                    $comment = $this->commentRepository->getById($commentId);
                    $comment->setCommentJson($commentJson);
                }else{
                    /** @var PostEntity $post */
                    $post = $this->postRepository->getById($postId);
                    $comment = new Comment();
                    $comment
                        ->setPost($post)
                        ->setUser($user)
                        ->setCommentJson($this->generateCommentJson($commentContent))
                        ->setCreatedAt();
                }

                $comment
                    ->setComment($commentContent)
                    ->setUpdatedAt();
                // Save Comment
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
            'success' => false,
        ]);
    }

    /**
     * @param string $comment
     * @return string
     */
    public function generateCommentJson(string $comment): string
    {
        $commentJson = [
            "assets" => [],
            "styles" => [
                [
                    "selectors" => ["#my-wrapper"],
                    "style" => [
                        "width" => "900px",
                        "margin-right" => "auto",
                        "margin-left" => "auto",
                        "padding-top" => "25px",
                        "padding-right" => "35px",
                        "padding-bottom" => "25px",
                        "padding-left" => "35px",
                        "margin-top" => "15px",
                        "margin-bottom" => "15px",
                        "border-top-width" => "1px",
                        "border-right-width" => "1px",
                        "border-bottom-width" => "1px",
                        "border-left-width" => "1px",
                        "border-top-style" => "solid",
                        "border-right-style" => "solid",
                        "border-bottom-style" => "solid",
                        "border-left-style" => "solid",
                        "border-top-color" => "rgb(204, 204, 204)",
                        "border-right-color" => "rgb(204, 204, 204)",
                        "border-bottom-color" => "rgb(204, 204, 204)",
                        "border-left-color" => "rgb(204, 204, 204)",
                        "border-image-source" => "initial",
                        "border-image-slice" => "initial",
                        "border-image-width" => "initial",
                        "border-image-outset" => "initial",
                        "border-image-repeat" => "initial",
                        "background-color" => "rgb(255, 255, 255)",
                        "min-height" => "1000px"
                    ]
                ],
                [
                    "selectors" => ["#my-wrapper"],
                    "style" => [
                        "direction" => "rtl"
                    ]
                ]
            ],
            "pages" => [
                [
                    "frames" => [
                        [
                            "component" => [
                                "type" => "wrapper",
                                "stylable" => [
                                    "background",
                                    "background-color",
                                    "background-image",
                                    "background-repeat",
                                    "background-attachment",
                                    "background-position",
                                    "background-size"
                                ],
                                "attributes" => [
                                    "id" => "my-wrapper"
                                ],
                                "components" => [
                                    [
                                        "tagName" => "p",
                                        "type" => "text",
                                        "attributes" => [
                                            "id" => "isaw"
                                        ],
                                        "components" => [
                                            [
                                                "type" => "textnode",
                                                "content" => $comment
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            "id" => "ag9oKrdL4Da0fxSO"
                        ]
                    ],
                    "id" => "XVZ1WyCux1YH1MNC"
                ]
            ]
        ];

        return json_encode($commentJson);
    }
}