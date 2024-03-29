<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Repository;

use ProgramCms\WebsiteBundle\Entity\Website;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Website>
 *
 * @method Website|null find($id, $lockMode = null, $lockVersion = null)
 * @method Website|null findOneBy(array $criteria, array $orderBy = null)
 * @method Website[]    findAll()
 * @method Website[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WebsiteRepository extends ServiceEntityRepository
{
    /**
     * WebsiteRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Website::class);
    }

    /**
     * @param int $websiteId
     * @return Website|null
     */
    public function getById(int $websiteId): ?Website
    {
        return $this->findOneBy(['website_id' => $websiteId]);
    }

    /**
     * @param string $code
     * @return Website|null
     */
    public function getByCode(string $code): ?Website
    {
        return $this->findOneBy(['website_code' => $code]);
    }

    /**
     * @param Website $entity
     * @param bool $flush
     */
    public function save(Website $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Website $entity
     * @param bool $flush
     */
    public function remove(Website $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Website|null
     */
    public function getDefaultWebsite(): ?Website
    {
        return $this->findOneBy(['is_default' => 1]);
    }
}
