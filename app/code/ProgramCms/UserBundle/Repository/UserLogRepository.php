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
use ProgramCms\UserBundle\Entity\UserLog;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserLogRepository
 * @package ProgramCms\UserBundle\Repository
 */
class UserLogRepository extends AbstractRepository
{
    /**
     * UserLogRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserLog::class);
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
     * @param UserEntity $userEntity
     * @return object|null
     */
    public function getLastLog(UserEntity $userEntity): ?object
    {
        return $this->findOneBy(['user' => $userEntity], ['entity_id' => 'desc']);
    }
}
