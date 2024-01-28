<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository;

use ProgramCms\UserBundle\Entity\UserEntityDecimal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserEntityDecimal>
 *
 * @method UserEntityDecimal|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEntityDecimal|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEntityDecimal[]    findAll()
 * @method UserEntityDecimal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEntityDecimalRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntityDecimal::class);
    }

    public function save(UserEntityDecimal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserEntityDecimal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
