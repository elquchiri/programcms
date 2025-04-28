<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostReactionBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostReactionBundle\Entity\PostReaction;
use ProgramCms\UserBundle\Entity\UserEntity;

/**
 * Class PostReactionRepository
 * @package ProgramCms\PostReactionBundle\Repository
 */
class PostReactionRepository extends AbstractRepository
{
    /**
     * PostReactionRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostReaction::class);
    }

    /**
     * @param UserEntity $user
     * @param PostEntity $post
     * @return object|null
     */
    public function getByReaction(UserEntity $user, PostEntity $post)
    {
        return $this->findOneBy([
            'user' => $user,
            'post' => $post
        ]);
    }

    /**
     * @param PostEntity $post
     * @return object[]
     */
    public function getByPost(PostEntity $post)
    {
        return $this->findBy(['post' => $post]);
    }
}