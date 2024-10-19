<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model;

use ProgramCms\ConfigBundle\Model\Structure\Element\FlyweightFactory;
use ProgramCms\ConfigBundle\Model\Structure\Element\Tab;
use ProgramCms\CoreBundle\Model\ObjectManager;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Container;
use ReflectionException;
use Exception;

/**
 * Class ConfigSerializer
 * @package ProgramCms\ConfigBundle\Model
 */
class ConfigSerializer
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var Structure\Element\FlyweightFactory
     */
    protected Structure\Element\FlyweightFactory $flyweightFactory;

    /**
     * @var ScopeDefiner
     */
    protected ScopeDefiner $_scopeDefiner;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * Stores Hole Merged Configuration
     * @var array
     */
    private array $_data;

    /**
     * List of cached elements
     * @var array
     */
    private array $_elements;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Structure\Element\Iterator\Tab
     */
    protected Structure\Element\Iterator\Tab $_tabIterator;

    /**
     * ConfigSerializer constructor.
     * @param Container $container
     * @param Structure\Element\FlyweightFactory $flyweightFactory
     * @param ObjectManager $objectManager
     * @param ScopeDefiner $scopeDefiner
     * @param Structure\Element\Iterator\Tab $_tabIterator
     * @param Security $security
     * @throws ReflectionException
     */
    public function __construct(
        Container $container,
        FlyweightFactory $flyweightFactory,
        ObjectManager $objectManager,
        ScopeDefiner $scopeDefiner,
        Structure\Element\Iterator\Tab $_tabIterator,
        Security $security
    )
    {
        $this->_data = [];
        $this->container = $container;
        $this->objectManager = $objectManager;
        $this->flyweightFactory = $flyweightFactory;
        $this->_scopeDefiner = $scopeDefiner;
        $this->_tabIterator = $_tabIterator;
        $this->security = $security;

        // Parse Config
        $this->parseConfig();
    }

    /**
     * Parse all Bundle's configurations
     * TODO: cache config data $_data
     * @throws ReflectionException
     */
    private function parseConfig()
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
                if (!isset(\Symfony\Component\Yaml\Yaml::parseFile($configFilePath)['system_config'])) {
                    // Ignore current configuration if system_config argument not found
                    continue;
                }

                $config = \Symfony\Component\Yaml\Yaml::parseFile($configFilePath)['system_config'];

                if (isset($config['tab'])) {
                    // ACL Check
                    if($this->notGranted($config['tab'])) {
                        continue;
                    }
                    if (isset($config['tab']['id']) && isset($config['tab']['label'])) {
                        $tabId = $config['tab']['id'];
                        $this->_data['tabs'][$tabId] = [
                            'id' => $tabId,
                            'label' => $config['tab']['label'],
                            'elementType' => 'tab',
                            'sortOrder' => $config['tab']['sortOrder'] ?? 999
                        ];
                    }
                }

                if (isset($config['sections'])) {
                    foreach ($config['sections'] as $sectionId => $section) {
                        // ACL Check
                        if($this->notGranted($section)) {
                            continue;
                        }
                        if (isset($section['tab'])) {
                            $this->_data['sections'][$sectionId] = [
                                'id' => $sectionId,
                                'label' => $section['label'],
                                'elementType' => 'section',
                                'tab' => $section['tab'] ?? '',
                                'scope' => isset($section['scope']) ? explode('|', $section['scope']) : []
                            ];
                        }
                        if (isset($section['groups'])) {
                            foreach ($section['groups'] as $groupId => $group) {
                                // ACL Check
                                if($this->notGranted($group)) {
                                    continue;
                                }
                                if (isset($group['label'])) {
                                    $this->_data['sections'][$sectionId]['children'][$groupId] = [
                                        'id' => $groupId,
                                        'label' => $group['label'],
                                        'elementType' => 'group',
                                        'path' => $sectionId . '/' . $groupId,
                                        'scope' => isset($group['scope']) ? explode('|', $group['scope']) : []
                                    ];
                                }
                                if (isset($group['fields'])) {
                                    foreach ($group['fields'] as $fieldId => $field) {
                                        // ACL Check
                                        if($this->notGranted($field)) {
                                            continue;
                                        }
                                        $this->_data['sections'][$sectionId]['children'][$groupId]['children'][$fieldId] = [
                                            'id' => $fieldId,
                                            'label' => $field['label'],
                                            'elementType' => 'field',
                                            'type' => $field['type'],
                                            'frontend_model' => $field['frontend_model'] ?? '',
                                            'backend_model' => $field['backend_model'] ?? '',
                                            'helpMessage' => isset($field['helpMessage']) ? $field['helpMessage'] : '',
                                            'scope' => isset($field['scope']) ? explode('|', $field['scope']) : [],
                                            'path' => $sectionId . '/' . $groupId . '/' . $fieldId
                                        ];

                                        if (in_array($field['type'], ['select', 'multiselect'])) {
                                            $this->_data['sections'][$sectionId]['children'][$groupId]['children'][$fieldId]['sourceModel'] = $field['source'] ?? '';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        uasort($this->_data['tabs'], function ($firstItem, $secondItem) {
            return $firstItem['sortOrder'] <=> $secondItem['sortOrder'];
        });
    }

    /**
     * @param array $menuItem
     * @return bool
     */
    public function notGranted(array $menuItem): bool
    {
        if(isset($menuItem['acl'])) {
            if(!$this->security->isGranted($menuItem['acl'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $path
     * @return mixed|object|null
     */
    public function getElement($path)
    {
        return $this->getElementByPath(explode('/', $path));
    }

    /**
     * @param array $path
     * @return mixed|object|null
     */
    public function getElementByPath(array $path)
    {
        $pathTag = implode('_', $path);;
        if(isset($this->_elements[$pathTag])) {
            return $this->_elements[$pathTag];
        }
        $children = [];
        if ($this->_data) {
            $children = $this->_data['sections'];
        }
        $child = [];
        foreach($path as $part) {
            if ($children && (array_key_exists($part, $children))) {
                $child = $children[$part];
                $children = array_key_exists('children', $child) ? $child['children'] : [];
            }else {
                $child = $this->_createEmptyElement($path);
                break;
            }
        }
        $this->_elements[$pathTag] = $this->flyweightFactory->create($child['elementType']);
        $this->_elements[$pathTag]->setData($child, $this->_scopeDefiner->getScope());
        return $this->_elements[$pathTag];
    }

    /**
     * @param array $path
     * @return array
     */
    protected function _createEmptyElement(array $path)
    {
        $elementType = match (count($path)) {
            1 => 'section',
            2 => 'group',
            default => 'field',
        };
        $elementId = array_pop($path);
        return ['id' => $elementId, 'path' => implode('/', $path), '_elementType' => $elementType];
    }

    /**
     * @return Structure\AbstractElement
     * @throws Exception
     */
    public function getFirstSection()
    {
        $tabs = $this->getTabs();
        $tabs->rewind();
        /** @var Tab $tab */
        $tab = $tabs->current();
        $tab->getChildren()->rewind();
        if (!$tab->getChildren()->current()->isVisible()) {
            throw new Exception('Visible section not found.');
        }

        return $tab->getChildren()->current();
    }

    /**
     * @return Structure\Element\Iterator\Tab
     */
    public function getTabs(): Structure\Element\Iterator\Tab
    {
        if (isset($this->_data['sections'])) {
            foreach ($this->_data['sections'] as $sectionId => $section) {
                if (isset($section['tab']) && $section['tab']) {
                    $this->_data['tabs'][$section['tab']]['children'][$sectionId] = $section;
                }
            }
            $this->_tabIterator->setElements($this->_data['tabs'], $this->_scopeDefiner->getScope());
        }
        return $this->_tabIterator;
    }
}