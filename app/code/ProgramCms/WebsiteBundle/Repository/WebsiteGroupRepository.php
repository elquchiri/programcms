<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Repository;

use ProgramCms\WebsiteBundle\Entity\WebsiteGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WebsiteGroup>
 *
 * @method WebsiteGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method WebsiteGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method WebsiteGroup[]    findAll()
 * @method WebsiteGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebsiteGroupRepository extends ServiceEntityRepository
{
    /**
     * WebsiteRootRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebsiteGroup::class);
    }

    /**
     * @param int $websiteGroupId
     * @return WebsiteGroup|null
     */
    public function getById(int $websiteGroupId): ?WebsiteGroup
    {
        return $this->findOneBy(['website_group_id' => $websiteGroupId]);
    }

    /**
     * @param WebsiteGroup $entity
     * @param bool $flush
     */
    public function save(WebsiteGroup $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param WebsiteGroup $entity
     * @param bool $flush
     */
    public function remove(WebsiteGroup $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
