<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle;

use ProgramCms\CoreBundle\ProgramCmsCoreBundle;

/**
 * Class ProgramCmsThemeBundle
 * @package ProgramCms\ThemeBundle
 */
class ProgramCmsThemeBundle extends ProgramCmsCoreBundle
{
    public const VERSION = '1.0.0';

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [
            ProgramCmsCoreBundle::class
        ];
    }
}