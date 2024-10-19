<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository\Group;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\UserBundle\Entity\Group\UserGroupPermission;

/**
 * Class UserGroupPermissionRepository
 * @package ProgramCms\UserBundle\Repository\Group
 */
class UserGroupPermissionRepository extends AbstractRepository
{
    /**
     * UserGroupRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGroupPermission::class);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        return $this->findOneBy(['permission_id' => $id]);
    }
}