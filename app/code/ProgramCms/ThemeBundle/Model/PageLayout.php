<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Model;

/**
 * Class PageLayout
 * @package ProgramCms\ThemeBundle\Model
 */
class PageLayout
{
    protected \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager;
    protected \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList $directoryList;
    protected \ProgramCms\RouterBundle\Service\Request $request;

    public function __construct(
        \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager,
        \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList $directoryList,
        \ProgramCms\RouterBundle\Service\Request $request
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
     */
    public function getPageLayoutContents($pageLayoutName): string
    {
        $areaCode = $this->request->getCurrentAreaCode();
        $layoutPageContents = '';
        // Get all bundles
        $bundles = $this->bundleManager->getAllEfBundles();
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