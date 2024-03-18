<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

use Generator;
use ProgramCms\CoreBundle\Theme\ThemeInterface;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use ProgramCms\DependencyBundle\BundleDependenciesResolver;

/**
 * Class Kernel
 * @package App
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
    use BundleDependenciesResolver;

    /**
     * @var array
     */
    protected array $themes = [];

    /**
     * Get project dir path relative to the location of vendor directory
     * @return string
     */
    public function getProjectDir(): string
    {
        $reflection = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);
        $vendorDir = dirname(dirname($reflection->getFileName()));
        return realpath($vendorDir . '/../');
    }

    /**
     * @return string
     */
    public function getConfigDir(): string
    {
        return $this->getProjectDir() . '/config';
    }

    /**
     * Get App Bundles file path
     * @return string
     */
    public function getBundlesFilePath(): string
    {
        return $this->getConfigDir() . '/bundles.php';
    }

    /**
     * Get App Themes file path
     * @return string
     */
    public function getThemesFilePath(): string
    {
        return $this->getConfigDir() . '/themes.php';
    }

    /**
     * @return string
     */
    public function getCacheDir(): string
    {
        return $this->getProjectDir() . '/var/cache';
    }

    /**
     * Register bundles throw dependencies resolution stack
     * @see \ProgramCms\DependencyBundle\BundleDependenciesResolver::_getBundleInstances
     * @return iterable
     * @throws ReflectionException
     */
    public function registerBundles(): iterable
    {
        /** @var array $contents */
        $contents = require $this->getBundlesFilePath();
        $bundlesClasses = array_keys($contents);

        return $this->_getBundleInstances($this, $bundlesClasses);
    }

    /**
     * Register Themes
     * @return Generator
     */
    public function registerThemes(): Generator
    {
        $contents = require $this->getThemesFilePath();
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    /**
     * Initialize Themes
     */
    protected function initializeThemes()
    {
        $this->themes = [];
        foreach ($this->registerThemes() as $theme) {
            $name = $theme->getShortPath();
            if (isset($this->themes[$name])) {
                throw new \LogicException(sprintf('Trying to register two themes with the same name "%s".', $name));
            }
            $this->themes[$name] = $theme;
        }
    }

    /**
     * Initialize Themes, then Initializes the service container.
     */
    protected function initializeContainer()
    {
        // Initialize Themes before building the container
        $this->initializeThemes();
        parent::initializeContainer();
    }

    /**
     * @return array
     */
    protected function getKernelParameters(): array
    {
        $themes = [];
        $themesMetadata = [];

        /**
         * @var string $name
         * @var  ThemeInterface $theme
         */
        foreach ($this->themes as $name => $theme) {
            $themes[$name] = $theme::class;
            $themesMetadata[$name] = [
                'path' => $theme->getPath(),
                'namespace' => $theme->getNamespace(),
            ];
        }

        return array_merge(
            parent::getKernelParameters(),
            [
                'kernel.themes' => $themes,
                'kernel.themes_metadata' => $themesMetadata
            ]
        );
    }
}
