<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\EavBundle\Entity\EavEntityText;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class EavEntityTextRepository
 * @package ProgramCms\EavBundle\Repository
 */
class EavEntityTextRepository extends AbstractRepository
{
    /**
     * EavEntityTextRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavEntityText::class);
    }
}
