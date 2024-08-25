<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\FavoriteBundle\Repository;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\FavoriteBundle\Entity\Favorite;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\UserBundle\Entity\UserEntity;

/**
 * Class FavoriteRepository
 * @package ProgramCms\FavoriteBundle\Repository
 */
class FavoriteRepository extends AbstractRepository
{
    /**
     * FavoriteRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favorite::class);
    }

    /**
     * @param UserEntity $user
     * @param PostEntity $post
     * @return bool
     */
    public function isFavorite(UserEntity $user, PostEntity $post): bool
    {
        return $this->findOneBy([
            'user' => $user,
            'post' => $post
        ]) != null;
    }
}
