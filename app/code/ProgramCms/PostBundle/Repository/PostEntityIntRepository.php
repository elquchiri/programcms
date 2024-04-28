<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Repository;

use ProgramCms\PostBundle\Entity\PostEntityInt;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class PostEntityIntRepository
 * @package ProgramCms\PostBundle\Repository
 */
class PostEntityIntRepository extends AbstractRepository
{
    /**
     * PostEntityIntRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostEntityInt::class);
    }
}
