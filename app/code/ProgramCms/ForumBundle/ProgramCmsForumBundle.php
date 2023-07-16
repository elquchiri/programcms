<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ForumBundle;

/**
 * Class ProgramCmsForumBundle
 * @package ProgramCms\ForumBundle
 */
class ProgramCmsForumBundle extends \ProgramCms\CoreBundle\ProgramCmsCoreBundle
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