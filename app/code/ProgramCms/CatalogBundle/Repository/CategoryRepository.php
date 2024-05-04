<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Repository;

use ProgramCms\CatalogBundle\Entity\CategoryEntity;
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
        parent::__construct($registry, CategoryEntity::class);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        return $this->findOneBy(['entity_id' => $id]);
    }

    /**
     * Get Root Category
     * @return object|null
     */
    public function getRootCategory(): ?CategoryEntity
    {
        return $this->findOneBy([
            'parent' => null
        ]);
    }

    /**
     * Get Default Category
     * @return CategoryEntity|null
     */
    public function getDefaultCategory(): ?CategoryEntity
    {
        $rootCategory = $this->getRootCategory();
        return $rootCategory->getChildren()->first();
    }
}
