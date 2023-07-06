<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Repository;

use ProgramCms\ConfigBundle\Entity\CoreConfigData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CoreConfigData>
 *
 * @method CoreConfigData|null find($id, $lockMode = null, $lockVersion = null)
 * @method CoreConfigData|null findOneBy(array $criteria, array $orderBy = null)
 * @method CoreConfigData[]    findAll()
 * @method CoreConfigData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoreConfigDataRepository extends ServiceEntityRepository
{
    /**
     * CoreConfigDataRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoreConfigData::class);
    }

    /**
     * @param CoreConfigData $entity
     * @param bool $flush
     */
    public function save(CoreConfigData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param CoreConfigData $entity
     * @param bool $flush
     */
    public function remove(CoreConfigData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
