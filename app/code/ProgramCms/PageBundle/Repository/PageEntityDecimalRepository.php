<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Repository;

use ProgramCms\PageBundle\Entity\PageEntityDecimal;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class PageEntityDecimalRepository
 * @package ProgramCms\PageBundle\Repository
 */
class PageEntityDecimalRepository extends AbstractRepository
{
    /**
     * PageEntityDecimalRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageEntityDecimal::class);
    }
}
