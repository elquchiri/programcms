<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\Theme;

use ProgramCms\CoreBundle\View\Design\ThemeInterface;

/**
 * Interface ThemeProviderInterface
 * @package ProgramCms\CoreBundle\View\Design\Theme
 */
interface ThemeProviderInterface
{
    /**
     * Get Theme from DB by area and path
     *
     * @param string $fullPath
     * @return ThemeInterface
     */
    public function getThemeByFullPath($fullPath): ThemeInterface;

    /**
     * Get Theme by id
     * @param int $themeId
     * @return ThemeInterface
     */
    public function getThemeById($themeId): ThemeInterface;
}