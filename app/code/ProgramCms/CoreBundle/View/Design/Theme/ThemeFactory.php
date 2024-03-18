<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\Theme;

use ProgramCms\ThemeBundle\Entity\Theme;
use ProgramCms\ThemeBundle\Repository\ThemeRepository;

/**
 * Class ThemeFactory
 * @package ProgramCms\CoreBundle\View\Design\Theme
 */
class ThemeFactory
{
    /**
     * @var ThemeRepository
     */
    protected ThemeRepository $themeRepository;

    /**
     * ThemeFactory constructor.
     * @param ThemeRepository $themeRepository
     */
    public function __construct(
        ThemeRepository $themeRepository
    )
    {
        $this->themeRepository = $themeRepository;
    }

    /**
     * @param $themeId
     * @return Theme|null
     */
    public function create($themeId)
    {
        return $this->themeRepository->getById($themeId);
    }
}