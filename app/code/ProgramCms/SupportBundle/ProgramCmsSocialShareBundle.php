<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\SocialShareBundle;

use ProgramCms\CoreBundle\ProgramCmsCoreBundle;

/**
 * Class ProgramCmsSocialShareBundle
 * @package ProgramCms\ShareBundle
 */
class ProgramCmsSocialShareBundle extends ProgramCmsCoreBundle
{
    public const VERSION = '1.0.0';

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [
            ProgramCmsCoreBundle::class,
            \ProgramCms\ThemeBundle\ProgramCmsThemeBundle::class,
        ];
    }
}