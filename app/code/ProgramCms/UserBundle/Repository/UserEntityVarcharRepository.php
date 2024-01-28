<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository;

use ProgramCms\UserBundle\Entity\UserEntityVarchar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserEntityVarchar>
 *
 * @method UserEntityVarchar|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEntityVarchar|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEntityVarchar[]    findAll()
 * @method UserEntityVarchar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEntityVarcharRepository extends ServiceEntityRepository
{
    /**
     * UserEntityVarcharRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntityVarchar::class);
    }

    /**
     * @param UserEntityVarchar $entity
     * @param bool $flush
     */
    public function save(UserEntityVarchar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param UserEntityVarchar $entity
     * @param bool $flush
     */
    public function remove(UserEntityVarchar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
