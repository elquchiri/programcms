<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\RewriteBundle\Entity\UrlRewrite;

/**
 * Class UrlRewriteRepository
 * @package ProgramCms\RewriteBundle\Repository
 */
class UrlRewriteRepository extends AbstractRepository
{
    /**
     * UrlRewriteRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlRewrite::class);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        return $this->findOneBy([
            'url_rewrite_id' => $id
        ]);
    }
}