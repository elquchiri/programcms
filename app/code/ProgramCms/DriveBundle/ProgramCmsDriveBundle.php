<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DriveBundle;

use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\ThemeBundle\ProgramCmsThemeBundle;

/**
 * Class ProgramCmsDriveBundle
 * @package ProgramCms\DriveBundle
 */
class ProgramCmsDriveBundle extends ProgramCmsCoreBundle
{
    public const VERSION = '1.0.0';

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [
            ProgramCmsCoreBundle::class,
            ProgramCmsThemeBundle::class
        ];
    }
}