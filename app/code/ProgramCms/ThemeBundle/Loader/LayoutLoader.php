<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Loader;

use ProgramCms\CoreBundle\Model\Filesystem\DirectoryList;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\CoreBundle\View\FileSystem;
use ProgramCms\RouterBundle\Service\Request;
use ReflectionException;
use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use Twig\Source;

/**
 * Class LayoutLoader
 * @package ProgramCms\ThemeBundle\Loader
 */
class LayoutLoader implements LoaderInterface
{
    const DEFAULT_LAYOUT_FILE = 'default.layout.twig';

    /**
     * @var FileSystem
     */
    protected FileSystem $fileSystem;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var BundleManager
     */
    private BundleManager $bundleManager;

    /**
     * @var DirectoryList
     */
    private DirectoryList $directoryList;

    /**
     * @var array
     */
    private array $paths = [];

    /**
     * LayoutLoader constructor.
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
        $this->request = $request;
        $this->directoryList = $directoryList;
        $this->fileSystem = $fileSystem;
    }

    /**
     * @param $layoutName
     * @throws ReflectionException
     */
    private function _initLayoutPaths($layoutName)
    {
        $areaCode = $this->request->getCurrentAreaCode();

        // Get all bundles
        $bundles = $this->bundleManager->getAllBundles();
        foreach ($bundles as $bundle) {
            $params = ['bundle' => $bundle['name']];
            if ($areaCode) {
                $params['area'] = $areaCode;
            }
            $defaults = $this->fileSystem->getLayoutFileName(self::DEFAULT_LAYOUT_FILE, $params);
            $layouts = $this->fileSystem->getLayoutFileName($layoutName, $params);
            if(!empty($defaults)) {
                foreach($defaults as $default) {
                    $this->paths['default'][] = $default;
                }
            }
            if(!empty($layouts)) {
                foreach($layouts as $layout) {
                    $this->paths['layout'][] = $layout;
                }
            }
        }
    }

    /**
     * @param string $name
     * @return Source
     * @throws LoaderError|ReflectionException
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

        return new Source(
            $this->minifySource($source),
            $name,
            $path = ''
        );
    }

    /**
     * Remove Comments, new lines and whitespaces
     * @param string $source
     * @return array|string|string[]|null
     */
    private function minifySource(string $source)
    {
        return preg_replace(
            ['/{#(.*)#}/Uis', '/[[:blank:]]+/', '/%}[[:blank:]]*{%/Uis'],
            ['', ' ', '%} {%'],
            str_replace(["\n","\r","\t"], '', $source)
        );
    }

    /**
     * @param string $name
     * @throws LoaderError
     */
    private function _validateLayout(string $name): void
    {
        if (str_contains($name, "\0")) {
            throw new LoaderError('A layout name cannot contain NUL bytes.');
        }
    }

    /**
     * @param string $name
     * @return string
     */
    public function getCacheKey(string $name): string
    {
        return md5($this->request->getCurrentRequest()->getHost() . $name);
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