<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model;

use Doctrine\Common\Collections\Criteria;

/**
 * Class Loader
 * @package ProgramCms\ConfigBundle\Model
 */
class Loader
{
    /**
     * @var \ProgramCms\ConfigBundle\Repository\CoreConfigDataRepository
     */
    protected \ProgramCms\ConfigBundle\Repository\CoreConfigDataRepository $configDataRepository;

    /**
     * Loader constructor.
     * @param \ProgramCms\ConfigBundle\Repository\CoreConfigDataRepository $configDataRepository
     */
    public function __construct(
        \ProgramCms\ConfigBundle\Repository\CoreConfigDataRepository $configDataRepository
    )
    {
        $this->configDataRepository = $configDataRepository;
    }

    /**
     * @param $path
     * @param $scope
     * @param $scopeId
     * @param bool $full
     */
    public function getConfigByPath($path, $scope, $scopeId, $full = true)
    {
        $configs = $this->configDataRepository->matching(
            Criteria::create()
                ->where(Criteria::expr()->eq('scope', $scope))
                ->andWhere(Criteria::expr()->eq('scope_id', $scopeId))
                ->andWhere(Criteria::expr()->startsWith('path', $path . '/')
            )
        );
        $config = [];
        foreach($configs as $data) {
            if ($full) {
                $config[$data->getPath()] = [
                    'path' => $data->getPath(),
                    'value' => $data->getValue(),
                    'config_id' => $data->getConfigId(),
                ];
            } else {
                $config[$data->getPath()] = $data->getValue();
            }
        }
        return $config;
    }
}