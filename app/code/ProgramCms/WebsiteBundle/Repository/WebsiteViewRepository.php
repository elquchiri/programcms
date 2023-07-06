<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Repository;

use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WebsiteView>
 *
 * @method WebsiteView|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebsiteView|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebsiteView[]    findAll()
 * @method WebsiteView[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebsiteViewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebsiteView::class);
    }

    public function save(WebsiteView $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WebsiteView $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
