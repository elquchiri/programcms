<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Repository;

use ProgramCms\UserBundle\Entity\UserEavAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserEavAttribute>
 *
 * @method UserEavAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEavAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEavAttribute[]    findAll()
 * @method UserEavAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEavAttributeRepository extends ServiceEntityRepository
{
    /**
     * UserEavAttributeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEavAttribute::class);
    }

    /**
     * @param UserEavAttribute $entity
     * @param bool $flush
     */
    public function save(UserEavAttribute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param UserEavAttribute $entity
     * @param bool $flush
     */
    public function remove(UserEavAttribute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
