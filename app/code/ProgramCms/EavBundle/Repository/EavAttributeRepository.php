<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\EavBundle\Entity\EavAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavAttribute>
 *
 * @method EavAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavAttribute[]    findAll()
 * @method EavAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavAttributeRepository extends ServiceEntityRepository
{
    /**
     * EavAttributeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavAttribute::class);
    }

    /**
     * @param EavAttribute $entity
     * @param bool $flush
     */
    public function save(EavAttribute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param EavAttribute $entity
     * @param bool $flush
     */
    public function remove(EavAttribute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
