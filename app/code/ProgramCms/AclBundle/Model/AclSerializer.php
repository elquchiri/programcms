<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Model;

use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use Symfony\Component\Yaml\Yaml;

/**
 * Class AclSerializer
 * @package ProgramCms\AclBundle\Model
 */
class AclSerializer
{
    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * @var array
     */
    private array $acl = [];

    /**
     * AclSerializer constructor.
     * @param BundleManager $bundleManager
     */
    public function __construct(
        BundleManager $bundleManager
    )
    {
        $this->bundleManager = $bundleManager;

        // Parse ACL Config
        $this->parseConfig();
    }

    /**
     * @throws \ReflectionException
     */
    private function parseConfig()
    {
        // Get all bundles
        $bundles = $this->bundleManager->getAllBundles();
        foreach ($bundles as $bundle) {
            // Get the configuration file path for the bundle
            $reflectedBundle = new \ReflectionClass($bundle['class']);
            $bundleDirectory = dirname($reflectedBundle->getFileName());
            $configFilePath = $bundleDirectory . '/Resources/config/adminhtml/acl.yaml';
            // Load the configuration file
            if (file_exists($configFilePath)) {
                if (!isset(Yaml::parseFile($configFilePath)['acl'])) {
                    // Ignore current configuration if system_config argument not found
                    continue;
                }

                $config = Yaml::parseFile($configFilePath)['acl'];
                $this->acl = array_merge_recursive($this->acl, $config);
            }
        }
    }

    /**
     * @return array
     */
    public function getAcl(): array
    {
        return $this->acl;
    }
}