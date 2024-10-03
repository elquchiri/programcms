<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\Backend;

use ProgramCms\CoreBundle\Theme\BackendTheme;

/**
 * Class ProgramCmsBackendTheme
 * @package ProgramCms\Backend
 */
class ProgramCmsBackendTheme extends BackendTheme
{
    /**
     * @var string
     */
    protected string $name = 'ProgramCMS Backend Theme';

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

    /**
     * Return empty string for no parent association
     * @return string
     */
    public function getParent(): string
    {
        return '';
    }
}