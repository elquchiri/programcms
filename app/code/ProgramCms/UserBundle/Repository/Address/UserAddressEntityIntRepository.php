<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository\Address;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\UserBundle\Entity\Address\UserAddressEntityInt;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserAddressEntityIntRepository
 * @package ProgramCms\UserBundle\Repository\Address
 */
class UserAddressEntityIntRepository extends AbstractRepository
{
    /**
     * UserAddressEntityIntRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAddressEntityInt::class);
    }
}
