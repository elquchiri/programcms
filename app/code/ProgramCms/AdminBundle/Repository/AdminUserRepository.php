<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Repository;

use ProgramCms\AdminBundle\Entity\AdminUser;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class AdminUserRepository
 * @package ProgramCms\AdminBundle\Repository
 */
class AdminUserRepository extends AbstractRepository
{
    /**
     * AdminUserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminUser::class);
    }

    /**
     * @param string $email
     * @return AdminUser|null
     */
    public function getByEmail(string $email): ?AdminUser
    {
        return $this->findOneBy(['email' => $email]);
    }
}
