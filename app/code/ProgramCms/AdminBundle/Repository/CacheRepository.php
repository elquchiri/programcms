<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\AdminBundle\Entity\Cache;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class CacheRepository.php
 * @package ProgramCms\AdminBundle\Repository
 */
class CacheRepository extends AbstractRepository
{
    /**
     * CacheRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cache::class);
    }
}
