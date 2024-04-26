<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Repository;

use ProgramCms\CatalogBundle\Entity\CategoryEntityVarchar;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class CategoryEntityVarcharRepository
 * @package ProgramCms\CatalogBundle\Repository
 */
class CategoryEntityVarcharRepository extends AbstractRepository
{
    /**
     * CategoryEntityVarcharRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryEntityVarchar::class);
    }
}
