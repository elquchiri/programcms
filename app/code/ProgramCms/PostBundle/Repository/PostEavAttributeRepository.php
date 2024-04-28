<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\PostBundle\Entity\PostEavAttribute;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class PostEavAttributeRepository
 * @package ProgramCms\PostBundle\Repository
 */
class PostEavAttributeRepository extends AbstractRepository
{
    /**
     * PostEavAttributeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostEavAttribute::class);
    }
}