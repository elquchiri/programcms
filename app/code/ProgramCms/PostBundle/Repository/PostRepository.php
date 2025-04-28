<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;
use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\PostBundle\Entity\PostEntity;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PostRepository
 * @package ProgramCms\PostBundle\Repository
 */
class PostRepository extends AbstractRepository
{
    /**
     * PostRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostEntity::class);
    }

    public function getPostQueryBuilder($category)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->addSelect('p')
            ->where(':category MEMBER OF p.categories')
            ->orderBy('p.updated_at', 'desc')
            ->setParameter('category', $category);

        return $queryBuilder;
    }

    public function getPosts($category, $page){
        $pageSize = 10;
        $firstResult = ($page - 1) * $pageSize;

        $queryBuilder = $this->getPostQueryBuilder($category);

        // Set the returned page
        $queryBuilder->setFirstResult($firstResult);
        $queryBuilder->setMaxResults($pageSize);

        $query = $queryBuilder->getQuery();

        return new Paginator($query, true);
    }
}
