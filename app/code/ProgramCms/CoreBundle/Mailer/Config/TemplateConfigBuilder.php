<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Mailer\Config;

use Exception;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ReflectionException;
use ProgramCms\ConfigBundle\Model\ScopeDefiner;
use Symfony\Component\Yaml\Yaml;

/**
 * Class TemplateConfigBuilder
 * @package ProgramCms\CoreBundle\Mailer\Config
 */
class TemplateConfigBuilder
{
    const VALID_AREAS = ['frontend', 'adminhtml'];

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var ScopeDefiner
     */
    protected ScopeDefiner $_scopeDefiner;

    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * Stores Hole Merged Configuration
     * @var array
     */
    private array $data = [];

    /**
     * List of cached elements
     * @var array
     */
    private array $_elements;

    /**
     * ConfigSerializer constructor.
     * @param BundleManager $bundleManager
     * @param ObjectManager $objectManager
     * @param ScopeDefiner $scopeDefiner
     * @throws ReflectionException
     */
    public function __construct(
        BundleManager $bundleManager,
        ObjectManager $objectManager,
        ScopeDefiner $scopeDefiner,
    )
    {
        $this->objectManager = $objectManager;
        $this->_scopeDefiner = $scopeDefiner;
        $this->bundleManager = $bundleManager;

        // Parse Config
        $this->parseConfig();
    }

    /**
     * Parse all Bundle's configurations
     * TODO: cache config data
     * @throws ReflectionException
     */
    private function parseConfig()
    {
        // Get all bundles
        $bundles = $this->bundleManager->getAllBundles();
        foreach ($bundles as $bundle) {
            // Get the configuration file path for the bundle
            $configFilePath = $bundle['path'] . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'email_templates.yaml';
            // Load the configuration file
            if (file_exists($configFilePath)) {
                if (!isset(Yaml::parseFile($configFilePath)['template'])) {
                    // Ignore current configuration if system_config argument not found
                    continue;
                }

                $config = $this->formatConfig(
                    Yaml::parseFile($configFilePath)['template'],
                    $bundle['name']
                );
                $this->data = array_merge_recursive(
                    $this->data,
                    $config
                );
            }
        }
    }

    /**
     * @throws Exception
     */
    private function formatConfig(array $config, string $bundleName): array
    {
        foreach ($config as $templateId => $template) {
            if (!isset($template['file'])) {
                throw new Exception('file attribute not found in the config file.');
            }
            $config[$templateId]['file'] = "@" . $bundleName . '/email_templates/' . $template['file'];
        }
        return $config;
    }

    /**
     * @param string $templateId
     * @return string
     */
    public function getTemplate(string $templateId): string
    {
        return $this->data[$templateId]['file'];
    }

    /**
     * @param string $templateId
     * @return string
     */
    public function getArea(string $templateId): string
    {
        return $this->data[$templateId]['area'];
    }
}