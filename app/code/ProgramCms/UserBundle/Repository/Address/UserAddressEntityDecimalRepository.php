<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository\Address;

use ProgramCms\UserBundle\Entity\Address\UserAddressEntityDecimal;
use ProgramCms\CoreBundle\Repository\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserAddressEntityDecimalRepository
 * @package ProgramCms\UserBundle\Repository\Address
 */
class UserAddressEntityDecimalRepository extends AbstractRepository
{
    /**
     * UserAddressEntityDecimalRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAddressEntityDecimal::class);
    }
}
