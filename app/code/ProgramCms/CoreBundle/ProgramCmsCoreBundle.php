<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
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
     * @return string
     */
    public function getVersion(): string
    {
        return self::VERSION;
    }

    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        // Add Compiler Passes here
    }

    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }
}