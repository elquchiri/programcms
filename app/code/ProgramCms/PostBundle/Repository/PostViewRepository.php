<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\PostBundle\Entity\PostView;

/**
 * Class PostViewRepository
 * @package ProgramCms\PostBundle\Repository
 */
class PostViewRepository extends AbstractRepository
{
    /**
     * PostViewRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostView::class);
    }
}