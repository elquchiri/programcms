<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\UserBundle\Entity\UserEntityInt;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserEntityIntRepository
 * @package ProgramCms\UserBundle\Repository
 */
class UserEntityIntRepository extends AbstractRepository
{
    /**
     * UserEntityIntRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntityInt::class);
    }
}
