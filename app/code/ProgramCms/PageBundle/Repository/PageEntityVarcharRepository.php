<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Repository;

use ProgramCms\PageBundle\Entity\PageEntityVarchar;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class PageEntityVarcharRepository
 * @package ProgramCms\PageBundle\Repository
 */
class PageEntityVarcharRepository extends AbstractRepository
{
    /**
     * PageEntityVarcharRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageEntityVarchar::class);
    }
}
