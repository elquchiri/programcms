<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Repository;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\WebsiteBundle\Entity\Website;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class WebsiteRepository
 * @package ProgramCms\WebsiteBundle\Repository
 */
class WebsiteRepository extends AbstractRepository
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
     * @param int $id
     * @return Website|null
     */
    public function getById(int $id): ?object
    {
        return $this->findOneBy(['website_id' => $id]);
    }

    /**
     * @param string $code
     * @return object|null
     */
    public function getByCode(string $code): ?object
    {
        return $this->findOneBy(['website_code' => $code]);
    }

    /**
     * @return object
     */
    public function getDefaultWebsite(): object
    {
        return $this->findOneBy(['is_default' => 1]);
    }
}
