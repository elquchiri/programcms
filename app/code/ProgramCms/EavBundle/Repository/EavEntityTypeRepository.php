<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\EavBundle\Entity\EavEntityType;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class EavEntityTypeRepository
 * @package ProgramCms\EavBundle\Repository
 */
class EavEntityTypeRepository extends AbstractRepository
{
    /**
     * EavEntityTypeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavEntityType::class);
    }

    /**
     * Get Entity Type by Entity Namespace
     * @param string $typeCode
     * @return object|null
     */
    public function getByTypeCode(string $typeCode): ?object
    {
        return $this->findOneBy(['entity_type_code' => $typeCode]);
    }
}
