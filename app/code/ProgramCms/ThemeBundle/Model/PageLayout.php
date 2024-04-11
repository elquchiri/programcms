<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Model;

use ProgramCms\CoreBundle\Model\Filesystem\DirectoryList;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\CoreBundle\View\FileSystem;
use ProgramCms\RouterBundle\Service\Request;
use ReflectionException;

/**
 * Class PageLayout
 * @package ProgramCms\ThemeBundle\Model
 */
class PageLayout
{
    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * @var DirectoryList
     */
    protected DirectoryList $directoryList;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var FileSystem
     */
    protected FileSystem $fileSystem;

    /**
     * PageLayout constructor.
     * @param BundleManager $bundleManager
     * @param DirectoryList $directoryList
     * @param Request $request
     * @param FileSystem $fileSystem
     */
    public function __construct(
        BundleManager $bundleManager,
        DirectoryList $directoryList,
        Request $request,
        FileSystem $fileSystem
    )
    {
        $this->bundleManager = $bundleManager;
        $this->directoryList = $directoryList;
        $this->request = $request;
        $this->fileSystem = $fileSystem;
    }

    /**
     * Combine Requested PageLayoutName files found in bundles, picks from theme first
     * @param $pageLayoutName
     * @return string
     * @throws ReflectionException
     */
    public function getPageLayoutContents($pageLayoutName): string
    {
        $areaCode = $this->request->getCurrentAreaCode();
        $layoutPageContents = '';
        // Get all bundles
        $bundles = $this->bundleManager->getAllBundles();
        foreach ($bundles as $bundle) {
            $params = ['bundle' => $bundle['name']];
            if ($areaCode) {
                $params['area'] = $areaCode;
            }
            $pageLayouts = $this->fileSystem->getPageLayoutFileName($pageLayoutName . '.layout.twig', $params);
            if(!empty($pageLayouts)) {
                foreach($pageLayouts as $pageLayout) {
                    if(file_exists($pageLayout)) {
                        $layoutPageContents .= file_get_contents($pageLayout);
                    }
                }
            }
        }
        return $layoutPageContents;
    }

    /**
     * @param $layoutName
     * @return string
     * @throws ReflectionException
     */
    public function getLayoutContents($layoutName): string
    {
        $areaCode = $this->request->getCurrentAreaCode();
        $layoutPageContents = '';
        // Get all bundles
        $bundles = $this->bundleManager->getAllBundles();
        foreach ($bundles as $bundle) {
            $params = ['bundle' => $bundle['name']];
            if ($areaCode) {
                $params['area'] = $areaCode;
            }
            $pageLayouts = $this->fileSystem->getLayoutFileName($layoutName . '.layout.twig', $params);
            if(!empty($pageLayouts)) {
                foreach($pageLayouts as $pageLayout) {
                    if(file_exists($pageLayout)) {
                        $layoutPageContents .= file_get_contents($pageLayout);
                    }
                }
            }
        }
        return $layoutPageContents;
    }

    /**
     * @param $name
     * @return string
     * @throws ReflectionException
     */
    public function getUiComponentContents($name): string
    {
        $areaCode = $this->request->getCurrentAreaCode();
        $layoutPageContents = '';
        // Get all bundles
        $bundles = $this->bundleManager->getAllBundles();
        foreach ($bundles as $bundle) {
            $pageLayoutPath = $bundle['path'] . '/Resources/views/'. $areaCode .'/ui_component/' . $name . '.component.twig';
            $themeLayoutPath = $this->directoryList->getRoot() . '/themes/'. $areaCode . '/blank/' . $bundle['name'] . '/ui_component/' . $name . '.component.twig';

            if(file_exists($themeLayoutPath)) {
                $layoutPageContents .= file_get_contents($themeLayoutPath);
            } elseif (file_exists($pageLayoutPath)) {
                $layoutPageContents .= file_get_contents($pageLayoutPath);
            }
        }

        return $layoutPageContents;
    }
}