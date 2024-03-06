<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App\Config;

use ProgramCms\CoreBundle\App\DeploymentConfig\Reader;
use ProgramCms\CoreBundle\Exception\FileSystemException;
use ProgramCms\CoreBundle\Model\DataObject;

/**
 * Class InitialConfigSource
 * @package ProgramCms\CoreBundle\App\Config
 */
class InitialConfigSource implements ConfigSourceInterface
{
    /**
     * @var Reader
     */
    private Reader $reader;

    /**
     * @var string
     */
    private string $configType;

    /**
     * InitialConfigSource constructor.
     * @param Reader $reader
     * @param string $configType
     */
    public function __construct(
        Reader $reader,
        string $configType = ''
    )
    {
        $this->reader = $reader;
        $this->configType = $configType;
    }

    /**
     * @param string $path
     * @return array|mixed
     * @throws FileSystemException
     */
    public function get($path = '')
    {
        $data = new DataObject($this->reader->load());
        if ($path !== '' && $path !== null) {
            $path = '/' . $path;
        }
        return $data->getData($this->configType . $path) ?: [];
    }
}