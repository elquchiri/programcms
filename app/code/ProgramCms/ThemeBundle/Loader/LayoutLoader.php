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

    private \ProgramCms\RouterBundle\Service\Request $request;
    private \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager;
    private \ProgramCms\CoreBundle\Model\Filesystem\DirectoryList $directoryList;
    private array $paths;

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

    private function initLayoutPaths($layoutName)
    {
        $areaCode = $this->request->getCurrentAreaCode();

        // Get all bundles
        $bundles = $this->bundleManager->getAllEfBundles();
        foreach ($bundles as $bundle) {
            $layoutPath = $bundle['path'] . '/Resources/views/'. $areaCode .'/layout/';
            $themeLayoutPath = $this->directoryList->getRoot() . '/themes/'. $areaCode . '/ProgramCms/backend/' . $bundle['name'] . '/layout/';

            // Get all layout files
            if(is_file($themeLayoutPath . self::DEFAULT_LAYOUT_FILE)) {
                $this->paths['default'][] = $themeLayoutPath . self::DEFAULT_LAYOUT_FILE;
            }else if(is_file($layoutPath . self::DEFAULT_LAYOUT_FILE)) {
                $this->paths['default'][] = $layoutPath . self::DEFAULT_LAYOUT_FILE;
            }
            // Get all default files
            if(is_file($themeLayoutPath . $layoutName)) {
                $this->paths['layout'][] = $themeLayoutPath . $layoutName;
            } elseif (is_file($layoutPath . $layoutName)) {
                $this->paths['layout'][] = $layoutPath . $layoutName;
            }
        }
    }

    public function getSourceContext(string $name): Source
    {
        // Parse and populate current layout paths
        $this->initLayoutPaths($name);

        try {
            $this->validateLayout($name);
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
    private function validateLayout(string $name): void
    {
        if (false !== strpos($name, "\0")) {
            throw new LoaderError('A layout name cannot contain NUL bytes.');
        }
    }

    public function getCacheKey(string $name): string
    {
        return $name;
    }

    public function isFresh(string $name, int $time): bool
    {
        return true;
    }

    public function exists(string $name): bool
    {
        return true;
    }
}