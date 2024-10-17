<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\AclBundle\Entity\Role;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class RoleRepository
 * @package ProgramCms\AclBundle\Repository
 */
class RoleRepository extends AbstractRepository
{
    /**
     * RoleRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    /**
     * @param string $roleCode
     * @return object|null
     */
    public function getByRoleCode(string $roleCode): ?object
    {
        return $this->findOneBy([
            'role_code' => $roleCode
        ]);
    }
}