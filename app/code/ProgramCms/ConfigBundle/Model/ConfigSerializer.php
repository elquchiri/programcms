<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model;

use ReflectionException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ConfigSerializer
 * @package ProgramCms\ConfigBundle\Model
 */
class ConfigSerializer
{
    protected TranslatorInterface $translator;
    /**
     * Stores Hole Merged Configuration
     * @var array
     */
    private array $configs;
    /**
     * Holds current sectionId in URL
     * @var string
     */
    private string $sectionId;
    /**
     * @var Container
     */
    private $container;
    /**
     * @var Config
     */
    private Config $config;

    /**
     * ConfigSerializer constructor.
     * @param Container $container
     * @param TranslatorInterface $translator
     * @param Config $config
     */
    public function __construct(
        Container $container,
        TranslatorInterface $translator,
        \ProgramCms\ConfigBundle\Model\Config $config
    )
    {
        $this->configs = [];
        $this->sectionId = "";
        $this->container = $container;
        $this->config = $config;
        $this->translator = $translator;
    }

    /**
     * Parse all Bundle's configurations
     * @throws ReflectionException
     */
    public function parseConfig()
    {
        // Get all bundles
        $bundles = $this->container->getParameter('kernel.bundles');
        foreach ($bundles as $bundleClass) {
            // Get the configuration file path for the bundle
            $reflectedBundle = new \ReflectionClass($bundleClass);
            $bundleDirectory = dirname($reflectedBundle->getFileName());
            $configFilePath = $bundleDirectory . '/Resources/config/adminhtml/system.yaml';
            // Load the configuration file
            if (file_exists($configFilePath)) {
                if(!isset(\Symfony\Component\Yaml\Yaml::parseFile($configFilePath)['system_config'])) {
                    // Ignore current configuration if system_config argument not found
                    continue;
                }

                $config = \Symfony\Component\Yaml\Yaml::parseFile($configFilePath)['system_config'];

                if (isset($config['tab'])) {
                    if (isset($config['tab']['id']) && isset($config['tab']['label'])) {
                        $tabId = $config['tab']['id'];
                        $this->configs['tabs'][$tabId] = [
                            'label' => $this->translator->trans($config['tab']['label']),
                            'sortOrder' => $config['tab']['sortOrder'] ?? 999
                        ];
                    }
                }

                if (isset($config['sections'])) {
                    foreach ($config['sections'] as $sectionId => $section) {
                        // If no sectionId defined, get the first one as default
                        // Globally used with index action, so we pick the default section
                        if (empty($this->sectionId)) {
                            $this->sectionId = $sectionId;
                        }
                        if (isset($section['tab'])) {
                            $targetTabId = $section['tab'];
                            $this->configs['tabs'][$targetTabId]['sections'][$sectionId] = [
                                'label' => $this->translator->trans($section['label']),
                                'active' => $sectionId == $this->sectionId
                            ];
                            // Activate tab to show sections on view
                            if ($sectionId == $this->sectionId) {
                                $this->configs['tabs'][$targetTabId]['active'] = true;
                            }
                        }
                        // If current loop sectionId == current http section_id parameter, then merge groups & fields
                        if ($sectionId == $this->sectionId) {
                            //$this->sectionId = $sectionId;
                            if(isset($section['groups'])) {
                                foreach ($section['groups'] as $groupId => $group) {
                                    if (isset($group['label'])) {
                                        $this->configs['current_section']['groups'][$groupId] = [
                                            'label' => $this->translator->trans($group['label']),
                                            'fields' => []
                                        ];
                                    }
                                    if (isset($group['fields'])) {
                                        foreach ($group['fields'] as $fieldId => $field) {
                                            $this->configs['current_section']['groups'][$groupId]['fields'][$fieldId] = [
                                                'label' => $this->translator->trans($field['label']),
                                                'type' => $field['type'],
                                                'helpMessage' => $field['helpMessage'] ?? '',
                                                'value' => $this->config->getConfigValue(
                                                    $this->sectionId . '/' . $groupId . '/' . $fieldId
                                                )
                                            ];

                                            if ($field['type'] == 'select' || $field['type'] == 'multiselect') {
                                                $this->configs['current_section']['groups'][$groupId]['fields'][$fieldId]['sourceModel'] = $field['source'];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Set sectionId
     * @param $sectionId
     */
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
    }

    /**
     * Get sectionId
     * @return mixed
     */
    public function getSectionId()
    {
        return $this->sectionId;
    }

    /**
     * Get Configuration Navigation to render
     * @return array
     */
    public function getConfigNavigation(): array
    {
        return $this->_sortArrayByKey($this->configs['tabs'], 'sortOrder', 'asc');
    }

    /**
     * Get current section's groups tree
     * @return mixed
     */
    public function getCurrenSectionGroups(): array
    {
        return $this->configs['current_section']['groups'] ?? [];
    }

    /**
     * @param $array
     * @param $key
     * @param $sortOrder
     * @return mixed
     */
    private function _sortArrayByKey($array, $key, $sortOrder) {
        usort($array, function($a, $b) use ($key, $sortOrder) {
            if ($a[$key] == $b[$key]) {
                return 0;
            }

            if ($sortOrder === 'asc') {
                return ($a[$key] < $b[$key]) ? -1 : 1;
            } else if ($sortOrder === 'desc') {
                return ($a[$key] > $b[$key]) ? -1 : 1;
            }
        });

        return $array;
    }
}