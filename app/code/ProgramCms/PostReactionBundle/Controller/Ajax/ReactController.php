<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostReactionBundle\Controller\Ajax;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Repository\PostRepository;
use ProgramCms\PostReactionBundle\Entity\PostReaction;
use ProgramCms\PostReactionBundle\Repository\PostReactionRepository;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\PostReactionBundle\Enum\ReactionType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ReactController
 * @package ProgramCms\PostReactionBundle\Controller\Post
 */
class ReactController extends Controller
{
    /**
     * @var PostReactionRepository
     */
    protected PostReactionRepository $postReactionRepository;

    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * ReactController constructor.
     * @param Context $context
     * @param PostReactionRepository $postReactionRepository
     * @param PostRepository $postRepository
     */
    public function __construct(
        Context $context,
        PostReactionRepository $postReactionRepository,
        PostRepository $postRepository
    )
    {
        parent::__construct($context);
        $this->postReactionRepository = $postReactionRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @return JsonResponse
     */
    public function execute()
    {
        $data = ['status' => false];
        $postId = $this->getRequest()->getParam('post_id');
        $reactionType = $this->getRequest()->getParam('reaction_type');

        /** @var UserEntity $user */
        $user = $this->getUser();
        /** @var PostEntity $post */
        $post = $this->postRepository->getById($postId);

        if($post && $user) {
            /** @var PostReaction $postReaction */
            $postReaction = $this->postReactionRepository->getByReaction($user, $post);
            if(!$postReaction) {
                $postReaction = new PostReaction();
                $postReaction
                    ->setUser($user)
                    ->setPost($post)
                    ->setReactionType(ReactionType::from($reactionType))
                    ->updateTimestamps();
                $this->postReactionRepository->save($postReaction);
                $data['status'] = true;

            }else if($postReaction && $postReaction->getReactionType() !== ReactionType::from($reactionType)) {
                $postReaction
                    ->setReactionType(ReactionType::from($reactionType))
                    ->updateTimestamps();
                $this->postReactionRepository->save($postReaction);
                $data['status'] = true;
            }else{
                $this->postReactionRepository->remove($postReaction, true);
                $data['status'] = true;
            }
        }

        return $this->json($data);
    }
}