<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Loader;

use Twig\Error\LoaderError;
use Twig\Source;

/**
 * Class LayoutLoader
 * @package ProgramCms\ThemeBundle\Loader
 */
class LayoutLoader implements \Twig\Loader\LoaderInterface
{
    const DEFAULT_LAYOUT_FILE = 'default.layout.twig';
    /**
     * @var \ProgramCms\RouterBundle\Service\Request
     */
    private \ProgramCms\RouterBundle\Service\Request $request;
    /**
     * @var \ProgramCms\CoreBundle\Model\Utils\BundleManager
     */
    private \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager;
    /**
     * @var \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList
     */
    private \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList $directoryList;
    /**
     * @var array
     */
    private array $paths = [];

    public function __construct(
        \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager,
        \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList $directoryList,
        \ProgramCms\RouterBundle\Service\Request $request
    )
    {
        $this->bundleManager = $bundleManager;
        $this->request = $request;
        $this->directoryList = $directoryList;
    }

    /**
     * @param $layoutName
     */
    private function _initLayoutPaths($layoutName)
    {
        $areaCode = $this->request->getCurrentAreaCode();

        // Get all bundles
        $bundles = $this->bundleManager->getAllBundles();
        foreach ($bundles as $bundle) {
            $layoutPath = $bundle['path'] . '/Resources/views/'. $areaCode .'/layout/';
            $themeLayoutPath = $this->directoryList->getRoot() . '/themes/'. $areaCode . '/ProgramCms/backend/' . $bundle['name'] . '/layout/';

            // Get all default files
            if(is_file($themeLayoutPath . self::DEFAULT_LAYOUT_FILE)) {
                $this->paths['default'][] = $themeLayoutPath . self::DEFAULT_LAYOUT_FILE;
            }else if(is_file($layoutPath . self::DEFAULT_LAYOUT_FILE)) {
                $this->paths['default'][] = $layoutPath . self::DEFAULT_LAYOUT_FILE;
            }
            // Get all page layout files
            if(is_file($themeLayoutPath . $layoutName)) {
                $this->paths['layout'][] = $themeLayoutPath . $layoutName;
            } elseif (is_file($layoutPath . $layoutName)) {
                $this->paths['layout'][] = $layoutPath . $layoutName;
            }
        }
    }

    /**
     * @param string $name
     * @return Source
     * @throws LoaderError
     */
    public function getSourceContext(string $name): Source
    {
        // Parse and populate current layout paths
        $this->_initLayoutPaths($name);

        try {
            $this->_validateLayout($name);
        } catch (LoaderError $e) {
            throw $e;
        }

        $source = "";
        foreach($this->paths as $key => $path) {
            if($key == 'default') {
                foreach($this->paths['default'] as $defaultPath) {
                    $source .= file_get_contents($defaultPath);
                }
            }
            if($key == 'layout') {
                foreach($this->paths['layout'] as $layoutPath) {
                    $source .= file_get_contents($layoutPath);
                }
            }
        }

        return new Source($source, $name, $path = '');
    }

    /**
     * @param string $name
     * @throws LoaderError
     */
    private function _validateLayout(string $name): void
    {
        if (false !== strpos($name, "\0")) {
            throw new LoaderError('A layout name cannot contain NUL bytes.');
        }
    }

    /**
     * @param string $name
     * @return string
     */
    public function getCacheKey(string $name): string
    {
        return $name;
    }

    /**
     * @param string $name
     * @param int $time
     * @return bool
     */
    public function isFresh(string $name, int $time): bool
    {
        return true;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function exists(string $name): bool
    {
        return true;
    }
}