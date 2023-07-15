<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

declare(strict_types=1);

namespace ProgramCms\BundleDependencyBundle;

/**
 * Interface DependentBundleInterface
 * @package ProgramCms\BundleDependencyBundle
 */
interface DependentBundleInterface
{
    /**
     * @return array
     */
    public static function getDependencies(): array;
}