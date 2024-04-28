<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Repository;

use ProgramCms\PostBundle\Entity\PostEntityDatetime;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class PostEntityDatetimeRepository
 * @package ProgramCms\PostBundle\Repository
 */
class PostEntityDatetimeRepository extends AbstractRepository
{
    /**
     * PostEntityDatetimeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostEntityDatetime::class);
    }
}
