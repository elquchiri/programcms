<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\EavBundle\Entity\EavAttributeGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavAttributeGroup>
 *
 * @method EavAttributeGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavAttributeGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavAttributeGroup[]    findAll()
 * @method EavAttributeGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavAttributeGroupRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavAttributeGroup::class);
    }

    public function save(EavAttributeGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EavAttributeGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
