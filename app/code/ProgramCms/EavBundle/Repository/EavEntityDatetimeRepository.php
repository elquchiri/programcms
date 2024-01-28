<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\EavBundle\Entity\EavEntityDatetime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavEntityDatetime>
 *
 * @method EavEntityDatetime|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavEntityDatetime|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavEntityDatetime[]    findAll()
 * @method EavEntityDatetime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavEntityDatetimeRepository extends ServiceEntityRepository
{

    /**
     * EavEntityDatetimeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavEntityDatetime::class);
    }

    /**
     * @param EavEntityDatetime $entity
     * @param bool $flush
     */
    public function save(EavEntityDatetime $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param EavEntityDatetime $entity
     * @param bool $flush
     */
    public function remove(EavEntityDatetime $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
