<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle;

use ProgramCms\CmsBundle\ProgramCmsCmsBundle;
use ProgramCms\ConfigBundle\ProgramCmsConfigBundle;
use ProgramCms\ContentBundle\ProgramCmsContentBundle;
use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\ThemeBundle\ProgramCmsThemeBundle;
use ProgramCms\UiBundle\ProgramCmsUiBundle;
use ProgramCms\UserBundle\ProgramCmsUserBundle;

/**
 * Class ProgramCmsPageBundle
 * @package ProgramCms\PageBundle
 */
class ProgramCmsPageBundle extends ProgramCmsCoreBundle
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
            ProgramCmsUiBundle::class,
            ProgramCmsCmsBundle::class,
            ProgramCmsUserBundle::class,
            ProgramCmsContentBundle::class
        ];
    }
}