<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

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
     * Register bundles throw dependencies resolution stack
     * @see \ProgramCms\DependencyBundle\BundleDependenciesResolver::_getBundleInstances
     * @return iterable
     * @throws ReflectionException
     */
    public function registerBundles(): iterable
    {
        $contents = require $this->getBundlesFilePath();
        $bundlesClasses = array_keys($contents);

        return $this->_getBundleInstances($this, $bundlesClasses);
    }

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
     * @return string
     */
    public function getBundlesFilePath(): string
    {
        return $this->getConfigDir() . '/bundles.php';
    }

    /**
     * @return string
     */
    public function getCacheDir(): string
    {
        return $this->getProjectDir() . '/var/cache';
    }
}
