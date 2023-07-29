<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\EavBundle\Entity\EavAttributeLabel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavAttributeLabel>
 *
 * @method EavAttributeLabel|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavAttributeLabel|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavAttributeLabel[]    findAll()
 * @method EavAttributeLabel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavAttributeLabelRepository extends ServiceEntityRepository
{
    /**
     * EavAttributeLabelRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavAttributeLabel::class);
    }

    /**
     * @param EavAttributeLabel $entity
     * @param bool $flush
     */
    public function save(EavAttributeLabel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param EavAttributeLabel $entity
     * @param bool $flush
     */
    public function remove(EavAttributeLabel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
