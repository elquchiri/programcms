<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CategoryBundle\Repository;

use ProgramCms\CategoryBundle\Entity\CategoryEntityDatetime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryEntityDatetime>
 *
 * @method CategoryEntityDatetime|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryEntityDatetime|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryEntityDatetime[]    findAll()
 * @method CategoryEntityDatetime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryEntityDatetimeRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryEntityDatetime::class);
    }

    public function save(CategoryEntityDatetime $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategoryEntityDatetime $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
