<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Model;

use ReflectionException;

/**
 * Class MenuConfigSerializer
 * @package ProgramCms\AdminBundle\Model
 */
class MenuConfigSerializer
{
    /**
     * @var \ProgramCms\CoreBundle\Model\Utils\BundleManager
     */
    protected \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager;
    /**
     * @var \ProgramCms\RouterBundle\Service\Url
     */
    protected \ProgramCms\RouterBundle\Service\Url $url;
    protected \ProgramCms\CoreBundle\Data\Process\Sort $sort;
    /**
     * Stores Hole Merged Menu elements
     * @var array
     */
    private array $menu = [];

    /**
     * MenuConfigSerializer constructor.
     * @param \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager
     */
    public function __construct(
        \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager,
        \ProgramCms\RouterBundle\Service\Url $url,
        \ProgramCms\CoreBundle\Data\Process\Sort $sort
    )
    {
        $this->menu = [];
        $this->bundleManager = $bundleManager;
        $this->url = $url;
        $this->sort = $sort;
    }

    /**
     * Parse all Bundle's configurations
     * @throws ReflectionException
     */
    public function parseMenuConfig()
    {
        // Get all bundles
        $bundles = $this->bundleManager->getAllBundles();
        foreach ($bundles as $bundle) {
            // Get the configuration file path for the bundle
            $configFilePath = $bundle['path'] . '/Resources/config/adminhtml/menu.yaml';
            // Load the configuration file
            if (file_exists($configFilePath)) {
                $parser = \Symfony\Component\Yaml\Yaml::parseFile($configFilePath);
                if (isset($parser['menu'])) {
                    $menu = $parser['menu'];

                    foreach ($menu as $menuItemKey => $menuItem) {
                        $this->menu[$menuItemKey] = [
                            'label' => $menuItem['label'] ?? '',
                            'htmlClass' => $menuItem['htmlClass'] ?? '',
                            'sortOrder' => $menuItem['sortOrder'] ?? 5,
                            'action' => isset($menuItem['action']) ? $this->_getUrl($menuItem['action']) : '#'
                        ];

                        if (isset($menuItem['groups'])) {
                            foreach ($menuItem['groups'] as $groupKey => $group) {
                                $this->menu[$menuItemKey]['groups'][$groupKey] = [
                                    'label' => $groupKey == 'default' ? '' : $group['label'] ?? '',
                                    'sortOrder' => $group['sortOrder'] ?? 5
                                ];

                                if (isset($group['actions'])) {
                                    foreach ($group['actions'] as $actionKey => $action) {
                                        $this->menu[$menuItemKey]['groups'][$groupKey]['actions'][$actionKey] = [
                                            'label' => $action['label'] ?? '',
                                            'action' => isset($action['action']) ? $this->_getUrl($action['action']) : '',
                                            'sortOrder' => $action['sortOrder'] ?? 5
                                        ];
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
     * @return mixed
     */
    public function getMenu(): array
    {
        foreach($this->menu as $menuItemKey => $menuItem) {
            if (isset($menuItem['groups'])) {
                $this->menu[$menuItemKey]['groups'] = $this->sort->sortArrayByKey($menuItem['groups'], 'sortOrder', 'asc');
                foreach ($menuItem['groups'] as $groupKey => $group) {
                    $this->menu[$menuItemKey]['groups'][$groupKey]['actions'] = $this->sort->sortArrayByKey($group['actions'], 'sortOrder', 'asc');
                }
            }
        }

        return $this->sort->sortArrayByKey($this->menu, 'sortOrder', 'asc');
    }

    /**
     * @param $action
     * @return string
     */
    private function _getUrl($action): string
    {
        // Redirect to current url if action is defined but empty
        if(empty($action) || $action === '/') {
            return "";
        }else{
            return $this->url->getUrlByRouteName($action);
        }
    }
}