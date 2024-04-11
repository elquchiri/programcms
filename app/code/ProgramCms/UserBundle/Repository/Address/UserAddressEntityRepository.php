<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository\Address;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\UserBundle\Entity\Address\UserAddressEntity;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserAddressEntityRepository
 * @package ProgramCms\UserBundle\Repository\Address
 */
class UserAddressEntityRepository extends AbstractRepository
{
    /**
     * UserAddressEntityRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAddressEntity::class);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        return $this->findOneBy(['entity_id' => $id]);
    }
}
