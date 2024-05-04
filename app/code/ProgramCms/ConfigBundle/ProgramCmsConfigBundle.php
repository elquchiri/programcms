<?php
/*
 * Copyright © ProgramCms. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle;

use ProgramCms\AdminBundle\ProgramCmsAdminBundle;
use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\ThemeBundle\ProgramCmsThemeBundle;

/**
 * Class ProgramCmsConfigBundle
 * @package ProgramCms\ConfigBundle
 */
class ProgramCmsConfigBundle extends ProgramCmsCoreBundle
{
    public const VERSION = '1.0.0';

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [
            ProgramCmsCoreBundle::class,
            ProgramCmsThemeBundle::class,
            ProgramCmsAdminBundle::class
        ];
    }
}