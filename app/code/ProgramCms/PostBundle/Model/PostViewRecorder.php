<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Model;

use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Entity\PostView;
use ProgramCms\PostBundle\Repository\PostViewRepository;
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\UserBundle\Entity\UserEntity;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class PostViewRecorder
 * @package ProgramCms\PostBundle\Model
 */
class PostViewRecorder
{
    /**
     * @var PostViewRepository
     */
    protected PostViewRepository $postViewRepository;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * PostViewRecorder constructor.
     * @param Security $security
     * @param PostViewRepository $postViewRepository
     * @param Request $request
     */
    public function __construct(
        Security $security,
        PostViewRepository $postViewRepository,
        Request $request
    )
    {
        $this->postViewRepository = $postViewRepository;
        $this->security = $security;
        $this->request = $request;
    }

    /**
     * Record new Post View
     * @param PostEntity $post
     */
    public function record(PostEntity $post)
    {
        /** @var UserEntity $user */
        $user = $this->security->getUser();
        $postView = new PostView();
        $postView
            ->setPost($post)
            ->setIpAddress($this->request->getCurrentRequest()->getClientIp())
            ->updateTimestamps();

        if($user) {
            $postView->setUser($user);
        }else{
            $postView->setVisitorSessionId($this->request->getCurrentRequest()->getSession()->getId());
        }

        // Save the post view
        $this->postViewRepository->save($postView);
    }
}