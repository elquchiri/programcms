<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\EavBundle\Entity\EavEntityAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavEntityAttribute>
 *
 * @method EavEntityAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavEntityAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavEntityAttribute[]    findAll()
 * @method EavEntityAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavEntityAttributeRepository extends ServiceEntityRepository
{
    /**
     * EavEntityAttributeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavEntityAttribute::class);
    }

    /**
     * @param EavEntityAttribute $entity
     * @param bool $flush
     */
    public function save(EavEntityAttribute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param EavEntityAttribute $entity
     * @param bool $flush
     */
    public function remove(EavEntityAttribute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
