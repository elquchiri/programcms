<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository;

use ProgramCms\UserBundle\Entity\UserEntityText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserEntityText>
 *
 * @method UserEntityText|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEntityText|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEntityText[]    findAll()
 * @method UserEntityText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEntityTextRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntityText::class);
    }

    public function save(UserEntityText $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserEntityText $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
