<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Composer;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

/**
 * Auto Add Themes
 * Class InstallTheme
 * @package ProgramCms\ThemeBundle\Composer
 */
class InstallTheme
{
    /**
     * @param PackageEvent $event
     */
    public static function execute(PackageEvent $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
    }
}