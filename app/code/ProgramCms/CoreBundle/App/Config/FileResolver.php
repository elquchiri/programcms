<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App\Config;

use ProgramCms\CoreBundle\Bundle\Directory\Reader;
use ProgramCms\CoreBundle\Config\FileResolverInterface;
use ReflectionException;

/**
 * Class FileResolver
 * @package ProgramCms\CoreBundle\App\Config
 */
class FileResolver implements FileResolverInterface
{
    /**
     * @var Reader
     */
    protected Reader $reader;

    /**
     * FileResolver constructor.
     * @param Reader $reader
     */
    public function __construct(
        Reader $reader
    )
    {
        $this->reader = $reader;
    }

    /**
     * @param $filename
     * @param $scope
     * @return mixed
     * @throws ReflectionException
     */
    public function get($filename, $scope)
    {
        return match ($scope) {
            'global' => $this->reader->getConfigurationFiles($filename),
            default => $this->reader->getConfigurationFiles($scope . '/' . $filename),
        };
    }
}