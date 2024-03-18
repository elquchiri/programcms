<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\Blank;

use ProgramCms\CoreBundle\Theme\Theme;

/**
 * Class ProgramCmsBlankTheme
 * @package ProgramCms\Blank
 */
class ProgramCmsBlankTheme extends Theme
{
    /**
     * @var string
     */
    protected string $name = 'ProgramCMS Blank Theme';

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