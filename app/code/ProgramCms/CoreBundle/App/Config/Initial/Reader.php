<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App\Config\Initial;

use ProgramCms\CoreBundle\Config\FileResolverInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Reader
 * @package ProgramCms\CoreBundle\App\Config\Initial
 */
class Reader
{
    /**
     * @var string
     */
    protected string $fileName;

    /**
     * @var FileResolverInterface
     */
    protected FileResolverInterface $fileResolver;

    /**
     * @var string[]
     */
    protected array $scopePriorityScheme = ['global'];

    /**
     * Reader constructor.
     * @param FileResolverInterface $fileResolver
     * @param string $fileName
     */
    public function __construct(
        FileResolverInterface $fileResolver,
        string $fileName = 'config.yaml'
    )
    {
        $this->fileName = $fileName;
        $this->fileResolver = $fileResolver;
    }

    /**
     * Read config data from bundles
     * @return array
     */
    public function read()
    {
        $fileList = [];
        foreach ($this->scopePriorityScheme as $scope) {
            $directories = $this->fileResolver->get($this->fileName, $scope);
            foreach ($directories as $key => $directory) {
                $fileList[$key] = $directory;
            }
        }

        if (!count($fileList)) {
            return [];
        }

        $config = [];
        foreach ($fileList as $file) {
            $config = array_merge_recursive(
                Yaml::parse($file),
                $config
            );
        }

        return ['data' => $config['config']];
    }
}