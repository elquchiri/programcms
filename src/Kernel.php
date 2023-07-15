<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace App;

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
}
