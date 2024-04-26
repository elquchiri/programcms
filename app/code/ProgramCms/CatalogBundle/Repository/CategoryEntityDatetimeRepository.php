<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Repository;

use ProgramCms\CatalogBundle\Entity\CategoryEntityDatetime;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class CategoryEntityDatetimeRepository
 * @package ProgramCms\CatalogBundle\Repository
 */
class CategoryEntityDatetimeRepository extends AbstractRepository
{
    /**
     * CategoryEntityDatetimeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryEntityDatetime::class);
    }
}
