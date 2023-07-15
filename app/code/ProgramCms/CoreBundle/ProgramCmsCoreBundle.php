<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use ProgramCms\DependencyBundle\DependentBundleInterface;

/**
 * Class ProgramCmsCoreBundle
 * @package ProgramCms\CoreBundle
 */
class ProgramCmsCoreBundle extends Bundle implements DependentBundleInterface
{
    public const VERSION = '1.0.0';

    /**
     * Define bundle as ProgramCms Bundle Type
     * @return bool
     */
    public function isProgramCmsBundle(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return self::VERSION;
    }

    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }
}