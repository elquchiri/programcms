<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository;

use ProgramCms\UserBundle\Entity\UserEntityDatetime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserEntityDatetime>
 *
 * @method UserEntityDatetime|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEntityDatetime|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEntityDatetime[]    findAll()
 * @method UserEntityDatetime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEntityDatetimeRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntityDatetime::class);
    }

    public function save(UserEntityDatetime $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserEntityDatetime $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
