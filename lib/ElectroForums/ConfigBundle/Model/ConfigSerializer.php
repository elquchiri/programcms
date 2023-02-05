<?php


namespace ElectroForums\ConfigBundle\Model;


class ConfigSerializer
{

    private $container;

    private $configs;
    private $sectionId;

    public function __construct(
        \App\Kernel $kernel
    )
    {
        $this->container = $kernel->getContainer();
        $this->configs = [];
    }

    public function parseConfig() {
        // Get all bundles
        $bundles = array_keys($this->container->getParameter('kernel.bundles'));

        foreach ($bundles as $bundleName) {
            // Get the configuration of $bundleName (it's a list of configuration)
            $containerParamBundle = str_replace('Bundle', '', $bundleName);
            $containerParamBundle = strtolower(preg_replace('/(.)([A-Z])/', '$1_$2', $containerParamBundle));
            if($this->container->hasParameter($containerParamBundle)) {
                $config = $this->container->getParameter($containerParamBundle)['system_config'];
                if(isset($config['tab'])) {
                    if(isset($config['tab']['id']) && isset($config['tab']['label'])) {
                        $tabId = $config['tab']['id'];
                        $this->configs['tabs'][$tabId] = ['label' => $config['tab']['label']];
                    }
                }

                if(isset($config['sections'])) {
                    foreach($config['sections'] as $sectionId => $section) {
                        if(isset($section['tab'])) {
                            $targetTabId = $section['tab'];
                            $this->configs['tabs'][$targetTabId]['sections'][$sectionId] = [
                                'label' => $section['label'],
                                'active' => $sectionId == $this->sectionId
                            ];
                            // Activate tab to show sections on view
                            if($sectionId == $this->sectionId) {
                                $this->configs['tabs'][$targetTabId]['active'] = true;
                            }
                        }
                        // If current loop sectionId == current http section_id parameter, then merge groups & fields
                        if($sectionId == $this->sectionId) {
                            foreach($section['groups'] as $groupId => $group) {
                                if(isset($group['label'])) {
                                    $this->configs['current_section']['groups'][$groupId] = [
                                        'label' => $group['label'],
                                        'fields' => []
                                    ];
                                }
                                if(isset($group['fields'])) {
                                    foreach ($group['fields'] as $fieldId => $field) {
                                        $this->configs['current_section']['groups'][$groupId]['fields'][$fieldId] = [
                                            'label' => $field['label'],
                                            'type' => $field['type']
                                        ];

                                        if($field['type'] == 'select') {
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

    public function setSectionId($sectionId) {
        $this->sectionId = $sectionId;
    }

    public function getSectionId() {
        return $this->sectionId;
    }

    public function getConfigNavigation() {
        return $this->configs['tabs'];
    }

    public function getCurrenSectionGroups() {
        return $this->configs['current_section']['groups'];
    }
}