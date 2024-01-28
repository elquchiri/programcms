<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\EavBundle\Entity\EavEntityInt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavEntityInt>
 *
 * @method EavEntityInt|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavEntityInt|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavEntityInt[]    findAll()
 * @method EavEntityInt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavEntityIntRepository extends ServiceEntityRepository
{

    /**
     * EavEntityIntRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavEntityInt::class);
    }

    /**
     * @param EavEntityInt $entity
     * @param bool $flush
     */
    public function save(EavEntityInt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param EavEntityInt $entity
     * @param bool $flush
     */
    public function remove(EavEntityInt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
