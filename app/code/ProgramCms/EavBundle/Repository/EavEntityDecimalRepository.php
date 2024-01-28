<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\EavBundle\Entity\EavEntityDecimal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavEntityDecimal>
 *
 * @method EavEntityDecimal|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavEntityDecimal|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavEntityDecimal[]    findAll()
 * @method EavEntityDecimal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavEntityDecimalRepository extends ServiceEntityRepository
{

    /**
     * EavEntityDecimalRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavEntityDecimal::class);
    }

    /**
     * @param EavEntityDecimal $entity
     * @param bool $flush
     */
    public function save(EavEntityDecimal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param EavEntityDecimal $entity
     * @param bool $flush
     */
    public function remove(EavEntityDecimal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
