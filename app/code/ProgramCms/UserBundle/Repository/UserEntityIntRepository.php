<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository;

use ProgramCms\UserBundle\Entity\UserEntityInt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserEntityInt>
 *
 * @method UserEntityInt|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEntityInt|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEntityInt[]    findAll()
 * @method UserEntityInt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEntityIntRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntityInt::class);
    }

    public function save(UserEntityInt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserEntityInt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
