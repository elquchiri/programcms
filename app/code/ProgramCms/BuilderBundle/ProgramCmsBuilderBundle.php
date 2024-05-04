<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\BuilderBundle;

use ProgramCms\ConfigBundle\ProgramCmsConfigBundle;
use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\EavBundle\ProgramCmsEavBundle;
use ProgramCms\ThemeBundle\ProgramCmsThemeBundle;
use ProgramCms\WebsiteBundle\ProgramCmsWebsiteBundle;

/**
 * Class ProgramCmsBuilderBundle
 * @package ProgramCms\BuilderBundle
 */
class ProgramCmsBuilderBundle extends ProgramCmsCoreBundle
{
    public const VERSION = '1.0.0';

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [
            ProgramCmsCoreBundle::class,
            ProgramCmsConfigBundle::class,
            ProgramCmsThemeBundle::class,
            ProgramCmsEavBundle::class,
            ProgramCmsWebsiteBundle::class
        ];
    }
}