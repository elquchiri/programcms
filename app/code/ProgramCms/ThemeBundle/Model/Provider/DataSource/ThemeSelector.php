<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Model\Provider\DataSource;

use ProgramCms\ThemeBundle\Repository\ThemeRepository;
use ProgramCms\UiBundle\Model\Provider\DataSource\Options;

/**
 * Class ThemeSelector
 * @package ProgramCms\ThemeBundle\Model\Provider\DataSource
 */
class ThemeSelector extends Options
{
    /**
     * @var ThemeRepository
     */
    protected ThemeRepository $themeRepository;

    /**
     * ThemeSelector constructor.
     */
    public function __construct(
        ThemeRepository $themeRepository
    )
    {
        $this->themeRepository = $themeRepository;
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        $options = [];
        $themes = $this->themeRepository->getAllFrontendThemes();
        foreach($themes as $theme) {
            $options[$theme->getThemePath()] = $theme->getThemeTitle();
        }

        return $options;
    }
}