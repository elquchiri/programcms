<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\UserBundle\Entity\UserEntity;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserEntityRepository
 * @package ProgramCms\UserBundle\Repository
 */
class UserEntityRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntity::class);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        return $this->findOneBy(['entity_id' => $id]);
    }

    /**
     * Get User by email
     * @param string $email
     * @return UserEntity|null
     */
    public function getByEmail(string $email): ?object
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * Get User by reset token
     * @param string $token
     * @return object|null
     */
    public function getByResetToken(string $token): ?object
    {
        return $this->findOneBy(['reset_token' => $token]);
    }
}
