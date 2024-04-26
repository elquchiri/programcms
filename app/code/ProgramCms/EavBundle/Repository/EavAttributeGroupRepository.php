<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\EavBundle\Entity\EavAttributeGroup;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class EavAttributeGroupRepository
 * @package ProgramCms\EavBundle\Repository
 */
class EavAttributeGroupRepository extends AbstractRepository
{
    /**
     * EavAttributeGroupRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavAttributeGroup::class);
    }
}
