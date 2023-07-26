<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Framework;

/**
 * Class Theme
 * @package ProgramCms\ThemeBundle\Framework
 */
abstract class Theme extends AbstractTheme
{
    /**
     * Default Parent Theme
     * If no parent theme defined this one will be used.
     * @return string
     */
    public function getParent(): string
    {
        return 'ProgramCms/Blank';
    }
}