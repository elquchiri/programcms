<?php


namespace ElectroForums\ConfigBundle\Model;


class ConfigSerializer
{
    /**
     * Stores Hole Merged Configuration
     * @var array
     */
    private $configs;
    /**
     * Holds current sectionId in URL
     * @var
     */
    private $sectionId;
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    private $container;
    private Config $config;


    public function __construct(
        \Symfony\Component\DependencyInjection\Container $container,
        \ElectroForums\ConfigBundle\Model\Config $config
    )
    {
        $this->configs = [];
        $this->sectionId = null;
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * Parse all Bundle's configurations
     * @throws \ReflectionException
     */
    public function parseConfig()
    {
        // Get all bundles
        $bundles = $this->container->getParameter('kernel.bundles');
        foreach ($bundles as $bundleName => $bundleClass) {
            // Get the configuration file path for the bundle
            $reflectedBundle = new \ReflectionClass($bundleClass);
            $bundleDirectory = dirname($reflectedBundle->getFileName());
            $configFilePath = $bundleDirectory . '/Resources/config/system.yaml';
            // Load the configuration file
            if (file_exists($configFilePath)) {
                $config = \Symfony\Component\Yaml\Yaml::parseFile($configFilePath)['system_config'];

                if (isset($config['tab'])) {
                    if (isset($config['tab']['id']) && isset($config['tab']['label'])) {
                        $tabId = $config['tab']['id'];
                        $this->configs['tabs'][$tabId] = ['label' => $config['tab']['label']];
                    }
                }

                if (isset($config['sections'])) {
                    foreach ($config['sections'] as $sectionId => $section) {
                        // If no sectionId defined, get the first one as default
                        // Globally used with index action, so we pick the default section
                        if (!isset($this->sectionId)) {
                            $this->sectionId = $sectionId;
                        }
                        if (isset($section['tab'])) {
                            $targetTabId = $section['tab'];
                            $this->configs['tabs'][$targetTabId]['sections'][$sectionId] = [
                                'label' => $section['label'],
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
                            foreach ($section['groups'] as $groupId => $group) {
                                if (isset($group['label'])) {
                                    $this->configs['current_section']['groups'][$groupId] = [
                                        'label' => $group['label'],
                                        'fields' => []
                                    ];
                                }
                                if (isset($group['fields'])) {
                                    foreach ($group['fields'] as $fieldId => $field) {
                                        $this->configs['current_section']['groups'][$groupId]['fields'][$fieldId] = [
                                            'label' => $field['label'],
                                            'type' => $field['type'],
                                            'value' => $this->config->getConfigValue(
                                                $this->sectionId . '/' . $groupId . '/' . $fieldId
                                            )
                                        ];

                                        if ($field['type'] == 'select' || $field['type'] == 'multiselect') {
                                            $source = new \ReflectionClass($field['source']);
                                            $this->configs['current_section']['groups'][$groupId]['fields'][$fieldId]['source'] = $source->newInstance()->getOptionsArray();
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
     * @return mixed
     */
    public function getConfigNavigation()
    {
        return $this->configs['tabs'];
    }

    /**
     * Get current section's groups tree
     * @return mixed
     */
    public function getCurrenSectionGroups()
    {
        return $this->configs['current_section']['groups'];
    }
}