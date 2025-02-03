<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Repository;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\PageBundle\Entity\PageEntity;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PageRepository
 * @package ProgramCms\PageBundle\Repository
 */
class PageRepository extends AbstractRepository
{
    /**
     * PageRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageEntity::class);
    }

    /**
     * @param string $pageIdentifier
     * @return object|null
     */
    public function getByIdentifier(string $pageIdentifier): ?object
    {
        return $this->findOneBy([
            'page_identifier' => $pageIdentifier
        ]);
    }
}
