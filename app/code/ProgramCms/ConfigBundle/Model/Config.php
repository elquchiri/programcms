<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model;

/**
 * Class Config
 * @package ProgramCms\ConfigBundle\Model
 */
class Config
{
    const SCOPE_TYPE_DEFAULT = 'default';

    private \Symfony\Component\DependencyInjection\ContainerInterface $container;
    private \ProgramCms\ConfigBundle\Repository\CoreConfigDataRepository $coreConfigDataRepository;

    public function __construct(
        \ProgramCms\CoreBundle\App\Kernel $kernel,
        \ProgramCms\ConfigBundle\Repository\CoreConfigDataRepository $coreConfigDataRepository
    )
    {
        $this->container = $kernel->getContainer();
        $this->coreConfigDataRepository = $coreConfigDataRepository;
    }

    /**
     * @param $path
     * @param string $scopeType
     * @param int $scopeCode
     * @return mixed
     */
    public function getConfigValue($path, string $scopeType = self::SCOPE_TYPE_DEFAULT, int $scopeCode = 0): mixed
    {
        // Find configuration in core_config_data
        $result = $this->coreConfigDataRepository->findOneBy([
            'path' => $path,
            'scope' => $scopeType,
            'scope_id' => $scopeCode
        ]);
        if($result) {
            return $result->getValue();
        }
        // If no configuration found on database, get configuration's defaultValues from packages
        $pathArray = explode('/', $path);
        return $this->container->getParameter('programcms_system_config')['sections'][$pathArray[0]]['groups'][$pathArray[1]]['fields'][$pathArray[2]]['defaultValue'] ?? '';
    }

    /**
     * @param $path
     * @param $value
     * @param string $scopeType
     * @param int $scopeCode
     */
    public function setConfigValue($path, $value, string $scopeType = self::SCOPE_TYPE_DEFAULT, int $scopeCode = 0)
    {
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
}