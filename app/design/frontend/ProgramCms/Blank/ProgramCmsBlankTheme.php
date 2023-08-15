<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\Blank;

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
        return 'ProgramCMS Blank Theme';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return "This is the default ProgramCMS Frontend Theme";
    }

    /**
     * @return string[]
     */
    public function getAuthors(): array
    {
        return [
            'name' => "Mohamed EL QUCHIRI",
            'email' => 'elquchiri@gmail.com'
        ];
    }
}