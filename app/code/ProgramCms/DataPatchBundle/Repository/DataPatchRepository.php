<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DataPatchBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\DataPatchBundle\Entity\DataPatch;

/**
 * Class DataPatchRepository
 * @package ProgramCms\DataPatchBundle\Repository
 */
class DataPatchRepository extends AbstractRepository
{
    /**
     * DataPatchRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataPatch::class);
    }
}