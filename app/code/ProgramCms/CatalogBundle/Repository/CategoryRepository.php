<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Repository;

use ProgramCms\CatalogBundle\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class CategoryRepository
 * @package ProgramCms\CatalogBundle\Repository
 */
class CategoryRepository extends AbstractRepository
{
    /**
     * CategoryRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        return $this->findOneBy(['entity_id' => $id]);
    }
}
