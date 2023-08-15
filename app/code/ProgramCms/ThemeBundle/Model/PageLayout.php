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
     * PageLayout constructor.
     * @param BundleManager $bundleManager
     * @param DirectoryList $directoryList
     * @param Request $request
     */
    public function __construct(
        BundleManager $bundleManager,
        DirectoryList $directoryList,
        Request $request
    )
    {
        $this->bundleManager = $bundleManager;
        $this->directoryList = $directoryList;
        $this->request = $request;
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
            $pageLayoutPath = $bundle['path'] . '/Resources/views/'. $areaCode .'/page_layout/' . $pageLayoutName . '.layout.twig';
            $themeLayoutPath = $this->directoryList->getRoot() . '/themes/'. $areaCode . '/blank/' . $bundle['name'] . '/page_layout/' . $pageLayoutName . '.layout.twig';

            if(file_exists($themeLayoutPath)) {
                $layoutPageContents .= file_get_contents($themeLayoutPath);
            } elseif (file_exists($pageLayoutPath)) {
                $layoutPageContents .= file_get_contents($pageLayoutPath);
            }
        }

        return $layoutPageContents;
    }
}