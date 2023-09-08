<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Model;

use ProgramCms\CoreBundle\Data\Process\Sort;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\RouterBundle\Service\Url;
use ReflectionException;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class MenuConfigSerializer
 * @package ProgramCms\AdminBundle\Model
 */
class MenuConfigSerializer
{
    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;
    /**
     * @var Url
     */
    protected Url $url;
    /**
     * @var Sort
     */
    protected Sort $sort;
    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;
    /**
     * Stores Hole Merged Menu elements
     * @var array
     */
    private array $menu = [];

    /**
     * MenuConfigSerializer constructor.
     * @param BundleManager $bundleManager
     * @param Url $url
     * @param Sort $sort
     * @param TranslatorInterface $translator
     */
    public function __construct(
        BundleManager $bundleManager,
        Url $url,
        Sort $sort,
        TranslatorInterface $translator
    )
    {
        $this->menu = [];
        $this->bundleManager = $bundleManager;
        $this->url = $url;
        $this->sort = $sort;
        $this->translator = $translator;
    }

    /**
     * Parse all Bundle's Menu configurations
     * @throws ReflectionException
     */
    public function parseMenuConfig()
    {
        // Get all bundles
        $bundles = $this->bundleManager->getAllBundles();
        $menuTree = [];
        foreach ($bundles as $bundle) {
            // Get the configuration file path for the bundle
            $configFilePath = $bundle['path'] . '/Resources/config/adminhtml/menu.yaml';
            // Load the configuration file
            if (file_exists($configFilePath)) {
                $parser = \Symfony\Component\Yaml\Yaml::parseFile($configFilePath);
                if(isset($parser['menu'])) {
                    $menuTree = array_merge_recursive($menuTree, $parser);
                }
            }
        }
        /**
         * Process Menu Config
         */
        if (isset($menuTree['menu'])) {
            $menu = $menuTree['menu'];

            foreach ($menu as $menuItemKey => $menuItem) {
                $this->menu[$menuItemKey] = [
                    'label' => $menuItem['label'] ? $this->translator->trans($menuItem['label']) : '',
                    'htmlClass' => $menuItem['htmlClass'] ?? '',
                    'sortOrder' => $menuItem['sortOrder'] ?? 5,
                    'action' => isset($menuItem['action']) ? $this->_getUrl($menuItem['action']) : '#'
                ];

                if (isset($menuItem['groups'])) {
                    foreach ($menuItem['groups'] as $groupKey => $group) {
                        $this->menu[$menuItemKey]['groups'][$groupKey] = [
                            'label' => $groupKey == 'default' ? '' : $this->translator->trans($group['label']) ?? '',
                            'sortOrder' => $group['sortOrder'] ?? 5
                        ];

                        if (isset($group['actions'])) {
                            foreach ($group['actions'] as $actionKey => $action) {
                                $this->menu[$menuItemKey]['groups'][$groupKey]['actions'][$actionKey] = [
                                    'label' => $this->translator->trans($action['label']) ?? '',
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