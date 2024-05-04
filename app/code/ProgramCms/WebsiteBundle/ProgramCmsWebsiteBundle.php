<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle;

use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\ThemeBundle\ProgramCmsThemeBundle;
use ProgramCms\UiBundle\ProgramCmsUiBundle;

/**
 * Class ProgramCmsWebsiteBundle
 * @package ProgramCms\WebsiteBundle
 */
class ProgramCmsWebsiteBundle extends ProgramCmsCoreBundle
{
    public const VERSION = '1.0.0';

    /**
     * @return string[]
     */
    public static function getDependencies(): array
    {
        return [
            \ProgramCms\CoreBundle\ProgramCmsCoreBundle::class,
            \ProgramCms\ThemeBundle\ProgramCmsThemeBundle::class,
        ];
    }
}