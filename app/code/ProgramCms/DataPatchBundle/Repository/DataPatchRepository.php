<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DataPatchBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\DataPatchBundle\Entity\DataPatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<DataPatch>
 *
 * @method DataPatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataPatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataPatch[]    findAll()
 * @method DataPatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataPatchRepository extends ServiceEntityRepository
{
    /**
     * DataPatchRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataPatch::class);
    }

    /**
     * @param DataPatch $entity
     * @param bool $flush
     */
    public function save(DataPatch $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param DataPatch $entity
     * @param bool $flush
     */
    public function remove(DataPatch $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}