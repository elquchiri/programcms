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

    /**
     * @param string $requestPath
     * @param array $arguments
     * @return object|null
     */
    public function getByRequestPath(string $requestPath): ?object
    {
        return $this->findOneBy([
            'request_path' => $requestPath
        ], [
            'url_rewrite_id' => 'DESC'
        ]);
    }

    /**
     * @param string $targetPath
     * @param array $arguments
     * @return object|null
     */
    public function getByTargetPath(string $targetPath, array $arguments = []): ?object
    {
        return $this->findOneBy([
            'target_path' => $targetPath,
            'arguments' => !empty($arguments) ? json_encode($arguments) : ''
        ], [
            'url_rewrite_id' => 'DESC'
        ]);
    }
}