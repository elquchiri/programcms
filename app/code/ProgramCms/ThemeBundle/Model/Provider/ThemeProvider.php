<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Model\Provider;

use ProgramCms\CoreBundle\View\Design\Theme\ThemeProviderInterface;
use ProgramCms\CoreBundle\View\Design\ThemeInterface;
use ProgramCms\ThemeBundle\Repository\ThemeRepository;

/**
 * Class ThemeProvider
 * @package ProgramCms\ThemeBundle\Model\Provider
 */
class ThemeProvider implements ThemeProviderInterface
{
    /**
     * @var ThemeRepository
     */
    protected ThemeRepository $themeRepository;

    /**
     * ThemeProvider constructor.
     * @param ThemeRepository $themeRepository
     */
    public function __construct(
        ThemeRepository $themeRepository
    )
    {
        $this->themeRepository = $themeRepository;
    }

    /**
     * @param string $fullPath
     * @return ThemeInterface
     */
    public function getThemeByFullPath($fullPath): ThemeInterface
    {
        return $this->themeRepository->getByThemePath($fullPath);
    }

    /**
     * @param int $themeId
     * @return ThemeInterface
     */
    public function getThemeById($themeId): ThemeInterface
    {
        return $this->themeRepository->getById($themeId);
    }
}