<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\EavBundle\Entity\EavEntityVarchar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavEntityVarchar>
 *
 * @method EavEntityVarchar|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavEntityVarchar|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavEntityVarchar[]    findAll()
 * @method EavEntityVarchar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavEntityVarcharRepository extends ServiceEntityRepository
{
    /**
     * UserEntityVarcharRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavEntityVarchar::class);
    }

    /**
     * @param EavEntityVarchar $entity
     * @param bool $flush
     */
    public function save(EavEntityVarchar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param EavEntityVarchar $entity
     * @param bool $flush
     */
    public function remove(EavEntityVarchar $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
