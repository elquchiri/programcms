<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Repository;

use ProgramCms\PageBundle\Entity\PageEntityDatetime;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class PageEntityDatetimeRepository
 * @package ProgramCms\PageBundle\Repository
 */
class PageEntityDatetimeRepository extends AbstractRepository
{
    /**
     * PageEntityDatetimeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageEntityDatetime::class);
    }
}
