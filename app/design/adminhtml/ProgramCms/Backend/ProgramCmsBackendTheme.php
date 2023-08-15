<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\Backend;

/**
 * Class ProgramCmsBackendTheme
 * @package ProgramCms\Backend
 */
class ProgramCmsBackendTheme extends \ProgramCms\ThemeBundle\Framework\BackendTheme
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ProgramCMS Backend Theme';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return "This is the default ProgramCMS Backend Theme";
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