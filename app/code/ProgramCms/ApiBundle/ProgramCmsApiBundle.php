<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ApiBundle;

use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\ThemeBundle\ProgramCmsThemeBundle;

/**
 * Class ProgramCmsApiBundle
 * @package ProgramCms\ApiBundle
 */
class ProgramCmsApiBundle extends ProgramCmsCoreBundle
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