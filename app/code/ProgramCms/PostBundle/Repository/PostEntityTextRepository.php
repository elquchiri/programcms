<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Repository;

use ProgramCms\PostBundle\Entity\PostEntityText;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class PostEntityTextRepository
 * @package ProgramCms\PostBundle\Repository
 */
class PostEntityTextRepository extends AbstractRepository
{
    /**
     * PostEntityTextRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostEntityText::class);
    }
}
