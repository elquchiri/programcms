<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\PageBundle\Entity\PageEavAttribute;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class PageEavAttributeRepository
 * @package ProgramCms\PageBundle\Repository
 */
class PageEavAttributeRepository extends AbstractRepository
{
    /**
     * PageEavAttributeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageEavAttribute::class);
    }
}