<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View;

use ProgramCms\CoreBundle\View\Design\ThemeInterface;

/**
 * Interface DesignInterface
 * @package ProgramCms\CoreBundle\View
 */
interface DesignInterface
{
    const FRONTEND_AREA = 'frontend';

    const BACKEND_AREA = 'adminhtml';

    const FRONTEND_THEME_PATH_CONFIG = 'theme_config/theme_configuration/applied_theme';

    const BACKEND_THEME_PATH_CONFIG = 'system/backend_theme/applied_theme';

    /**
     * @return mixed
     */
    public function getArea();

    /**
     * Set theme path
     * @param ThemeInterface $theme
     * @param null $area
     * @return DesignInterface
     */
    public function setDesignTheme($theme, $area = null);

    /**
     * Get default theme which declared in configuration
     * @param string|null $area
     * @param array $params
     * @return string
     */
    public function getConfigurationDesignTheme($area = null, array $params = []);

    /**
     * Set default design theme
     * @return DesignInterface
     */
    public function setDefaultDesignTheme();

    /**
     * Design theme model getter
     * @return Design\ThemeInterface
     */
    public function getDesignTheme();

    /**
     * Convert theme model into a theme path
     * @param Design\ThemeInterface $theme
     * @return string
     */
    public function getThemePath(Design\ThemeInterface $theme);

    /**
     * Get locale
     * @return string
     */
    public function getLocale();

    /**
     * Get design settings for current request
     * @return array
     */
    public function getDesignParams();
}