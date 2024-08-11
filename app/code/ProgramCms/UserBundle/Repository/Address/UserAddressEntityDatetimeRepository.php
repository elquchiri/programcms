<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository\Address;

use ProgramCms\UserBundle\Entity\Address\UserAddressEntityDatetime;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class UserAddressEntityDatetimeRepository
 * @package ProgramCms\UserBundle\Repository\Address
 */
class UserAddressEntityDatetimeRepository extends AbstractRepository
{
    /**
     * UserAddressEntityDatetimeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAddressEntityDatetime::class);
    }
}
