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
    /**
     * WebsiteViewRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebsiteView::class);
    }

    /**
     * @param int $websiteViewId
     * @return WebsiteView|null
     */
    public function getById(int $websiteViewId): ?WebsiteView
    {
        return $this->findOneBy(['website_view_id' => $websiteViewId]);
    }

    /**
     * @param string $code
     * @return WebsiteView|null
     */
    public function getByCode(string $code): ?WebsiteView
    {
        return $this->findOneBy(['website_view_code' => $code]);
    }

    /**
     * @param WebsiteView $entity
     * @param bool $flush
     */
    public function save(WebsiteView $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param WebsiteView $entity
     * @param bool $flush
     */
    public function remove(WebsiteView $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
