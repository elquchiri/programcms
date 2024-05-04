<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle;

use ProgramCms\AdminBundle\ProgramCmsAdminBundle;
use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\ThemeBundle\ProgramCmsThemeBundle;
use ProgramCms\UiBundle\ProgramCmsUiBundle;
use ProgramCms\UserBundle\ProgramCmsUserBundle;

/**
 * Class ProgramCmsAdminChatBundle
 * @package ProgramCms\AdminChatBundle
 */
class ProgramCmsAdminChatBundle extends ProgramCmsCoreBundle
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
            ProgramCmsUiBundle::class,
            ProgramCmsAdminBundle::class,
            ProgramCmsUserBundle::class
        ];
    }
}