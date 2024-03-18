<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\App;

use ProgramCms\ConfigBundle\Entity\CoreConfigData;
use ProgramCms\ConfigBundle\Repository\CoreConfigDataRepository;

/**
 * Class Config
 * @package ProgramCms\ConfigBundle\App
 */
class Config implements ScopeConfigInterface
{
    /**
     * @var CoreConfigDataRepository
     */
    private CoreConfigDataRepository $coreConfigDataRepository;

    /**
     * Config constructor.
     * @param CoreConfigDataRepository $coreConfigDataRepository
     */
    public function __construct(
        CoreConfigDataRepository $coreConfigDataRepository
    )
    {
        $this->coreConfigDataRepository = $coreConfigDataRepository;
    }

    /**
     * @param $path
     * @param $value
     * @param string $scopeType
     * @param string $scopeCode
     */
    public function setConfigValue($path, $value, string $scopeType = self::SCOPE_TYPE_DEFAULT, string $scopeCode = '')
    {
        $scopeCode = empty($scopeCode) ? 0 : (int)$scopeCode;
        $config = $this->coreConfigDataRepository->findOneBy([
            'path' => $path,
            'scope' => $scopeType,
            'scope_id' => $scopeCode
        ]);

        // Check if config exists already, just set value to dispatch update
        if($config) {
            $config->setValue($value);
        }else{
            $config = new CoreConfigData();
            $config->setPath($path)
                ->setValue($value)
                ->setScope($scopeType)
                ->setScopeId($scopeCode);
        }

        // Persist & flush configuration
        $this->coreConfigDataRepository->save($config, true);
    }

    /**
     * @param $configId
     */
    public function deleteConfigValue($configId)
    {
        $config = $this->coreConfigDataRepository->findOneBy(['config_id' => $configId]);
        if($config) {
            $this->coreConfigDataRepository->remove($config, true);
        }
    }
}