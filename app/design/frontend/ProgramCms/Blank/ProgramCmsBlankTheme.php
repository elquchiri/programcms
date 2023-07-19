<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\BlankTheme;

/**
 * Class ProgramCmsBlankTheme
 * @package ProgramCms\Blank
 */
class ProgramCmsBlankTheme extends \ProgramCms\ThemeBundle\Framework\Theme
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ProgramCms/Blank';
    }
}