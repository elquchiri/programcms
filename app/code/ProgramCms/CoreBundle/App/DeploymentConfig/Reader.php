<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App\DeploymentConfig;

use ProgramCms\CoreBundle\Exception\FileSystemException;

/**
 * Class Reader
 * @package ProgramCms\CoreBundle\App\DeploymentConfig
 */
class Reader
{
    /**
     * Loads merged configuration within all configuration files.
     * @return array
     * @throws FileSystemException
     */
    public function load(): array
    {
        // TODO: Load configuration from global custom bundles project config
        // Not necessary for now.
        return [];
    }
}