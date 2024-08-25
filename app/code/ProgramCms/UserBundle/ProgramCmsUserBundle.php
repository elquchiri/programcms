<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle;

use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\FavoriteBundle\ProgramCmsFavoriteBundle;
use ProgramCms\NewsletterBundle\ProgramCmsNewsletterBundle;
use ProgramCms\ThemeBundle\ProgramCmsThemeBundle;

/**
 * Class ProgramCmsUserBundle
 * @package ProgramCms\UserBundle
 */
class ProgramCmsUserBundle extends ProgramCmsCoreBundle
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
            ProgramCmsNewsletterBundle::class,
            ProgramCmsFavoriteBundle::class
        ];
    }

}