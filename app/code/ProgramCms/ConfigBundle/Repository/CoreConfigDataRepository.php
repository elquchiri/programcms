<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Repository;

use ProgramCms\ConfigBundle\App\ScopeConfigInterface;
use ProgramCms\ConfigBundle\Entity\CoreConfigData;
use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class CoreConfigDataRepository
 * @package ProgramCms\ConfigBundle\Repository
 */
class CoreConfigDataRepository extends AbstractRepository
{
    /**
     * CoreConfigDataRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoreConfigData::class);
    }

    /**
     * @param $path
     * @param string $scope
     * @param string $scopeId
     * @return CoreConfigData|null
     */
    public function getByPath($path, string $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, string $scopeId = ''): ?object
    {
        return $this->findOneBy([
            'path' => $path,
            'scope' => $scope,
            'scope_id' => $scopeId
        ]);
    }
}
