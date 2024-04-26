<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\EavBundle\Entity\EavAttribute;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class EavAttributeRepository
 * @package ProgramCms\EavBundle\Repository
 */
class EavAttributeRepository extends AbstractRepository
{
    /**
     * EavAttributeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavAttribute::class);
    }
}
