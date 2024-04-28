<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle;

use ProgramCms\AdminBundle\ProgramCmsAdminBundle;
use ProgramCms\CatalogBundle\ProgramCmsCatalogBundle;
use ProgramCms\ConfigBundle\ProgramCmsConfigBundle;
use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\ThemeBundle\ProgramCmsThemeBundle;
use ProgramCms\UiBundle\ProgramCmsUiBundle;
use ProgramCms\UserBundle\ProgramCmsUserBundle;

/**
 * Class ProgramCmsPostBundle
 * @package ProgramCms\PostBundle
 */
class ProgramCmsPostBundle extends ProgramCmsCoreBundle
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
            ProgramCmsAdminBundle::class,
            ProgramCmsUserBundle::class,
            ProgramCmsCatalogBundle::class
        ];
    }
}