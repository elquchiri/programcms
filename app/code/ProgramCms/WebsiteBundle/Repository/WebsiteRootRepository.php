<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Repository;

use ProgramCms\WebsiteBundle\Entity\WebsiteRoot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WebsiteRoot>
 *
 * @method WebsiteRoot|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebsiteRoot|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebsiteRoot[]    findAll()
 * @method WebsiteRoot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebsiteRootRepository extends ServiceEntityRepository
{
    /**
     * WebsiteRootRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebsiteRoot::class);
    }

    /**
     * @param WebsiteRoot $entity
     * @param bool $flush
     */
    public function save(WebsiteRoot $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param WebsiteRoot $entity
     * @param bool $flush
     */
    public function remove(WebsiteRoot $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
