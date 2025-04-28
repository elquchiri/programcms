<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Repository;

use ProgramCms\CoreBundle\Entity\Bundle;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class BundleRepository
 * @package ProgramCms\ManagerBundle\Repository
 */
class BundleRepository extends AbstractRepository
{
    /**
     * PostRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bundle::class);
    }

    /**
     * @param string $shortName
     * @return object|null
     */
    public function getByShortName(string $shortName): ?object
    {
        return $this->findOneBy([
            'bundle_name' => $shortName
        ]);
    }
}
