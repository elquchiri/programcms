<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\App;

/**
 * Class Config
 * @package ProgramCms\ConfigBundle\App
 */
class Config implements ScopeConfigInterface
{
    /**
     * @var \ProgramCms\ConfigBundle\Repository\CoreConfigDataRepository
     */
    private \ProgramCms\ConfigBundle\Repository\CoreConfigDataRepository $coreConfigDataRepository;

    public function __construct(
        \ProgramCms\ConfigBundle\Repository\CoreConfigDataRepository $coreConfigDataRepository
    )
    {
        $this->coreConfigDataRepository = $coreConfigDataRepository;
    }

    /**
     * @param $path
     * @param string $scopeType
     * @param string $scopeCode
     * @return mixed
     */
    public function getConfigValue($path, string $scopeType = self::SCOPE_TYPE_DEFAULT, string $scopeCode = ''): mixed
    {
        // Find configuration in core_config_data
        $result = $this->coreConfigDataRepository->findOneBy([
            'path' => $path,
            'scope' => $scopeType,
            'scope_id' => empty($scopeCode) ? 0 : $scopeCode
        ]);
        if($result) {
            return $result->getValue();
        }
        return '';
        // If no configuration found on database, get configuration's defaultValues from packages
//        $pathArray = explode('/', $path);
//        return $this->container->getParameter('programcms_system_config')['sections'][$pathArray[0]]['groups'][$pathArray[1]]['fields'][$pathArray[2]]['defaultValue'] ?? '';
    }

    /**
     * @param $path
     * @param $value
     * @param string $scopeType
     * @param int $scopeCode
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
            $config = new \ProgramCms\ConfigBundle\Entity\CoreConfigData();
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