<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ForumSuite\ForumBundle;

use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\SearchBundle\ProgramCmsSearchBundle;
use ProgramCms\ThemeBundle\ProgramCmsThemeBundle;

/**
 * Class ForumSuiteForumBundle
 * @package ForumSuite\ForumBundle
 */
class ForumSuiteForumBundle extends ProgramCmsCoreBundle
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
            ProgramCmsSearchBundle::class
        ];
    }
}