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
        $contents = require $this->getProjectDir() . '/config/bundles.php';
        $bundlesClasses = array_keys($contents);

        return $this->_getBundleInstances($bundlesClasses);
    }
}
