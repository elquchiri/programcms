<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Repository;

use ProgramCms\CatalogBundle\Entity\CategoryEntityDecimal;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class CategoryEntityDecimalRepository
 * @package ProgramCms\CatalogBundle\Repository
 */
class CategoryEntityDecimalRepository extends AbstractRepository
{
    /**
     * CategoryEntityDecimalRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryEntityDecimal::class);
    }
}
