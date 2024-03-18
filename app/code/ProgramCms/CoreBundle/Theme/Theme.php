<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Theme;

/**
 * Class Theme
 * @package ProgramCms\CoreBundle\Theme
 */
abstract class Theme extends AbstractTheme
{
    /**
     * Default Frontend Theme
     */
    const DEFAULT_THEME = 'ProgramCms/Blank';

    /**
     * @var string
     */
    protected string $parent = self::DEFAULT_THEME;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * @return array
     */
    public function getAuthors(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getParent(): string
    {
        return parent::getParent() ?? self::DEFAULT_THEME;
    }
}