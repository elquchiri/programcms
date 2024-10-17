<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\AclBundle\Entity\Permission;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class PermissionRepository
 * @package ProgramCms\AclBundle\Repository
 */
class PermissionRepository extends AbstractRepository
{
    /**
     * PermissionRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permission::class);
    }
}