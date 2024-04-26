<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CatalogBundle\Entity\CategoryEavAttribute;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class CategoryEavAttributeRepository
 * @package ProgramCms\CatalogBundle\Repository
 */
class CategoryEavAttributeRepository extends AbstractRepository
{
    /**
     * CategoryEavAttributeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryEavAttribute::class);
    }
}