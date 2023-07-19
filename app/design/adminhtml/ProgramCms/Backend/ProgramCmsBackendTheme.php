<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\BackendTheme;

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
        return 'ProgramCms/Backend';
    }
}