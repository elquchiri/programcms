<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Bundle\Directory;

use ProgramCms\CoreBundle\Bundle\Directory;
use ProgramCms\CoreBundle\Config\FileIteratorFactory;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use Symfony\Component\Filesystem\Filesystem;
use Exception;
use ReflectionException;

/**
 * Class Reader
 * @package ProgramCms\CoreBundle\Bundle\Directory
 */
class Reader
{
    /**
     * @var Directory
     */
    protected Directory $directory;

    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * @var FileIteratorFactory
     */
    protected FileIteratorFactory $fileIteratorFactory;

    /**
     * @var array
     */
    private array $fileIterators = [];

    /**
     * Reader constructor.
     * @param FileIteratorFactory $fileIteratorFactory
     * @param Directory $directory
     * @param BundleManager $bundleManager
     * @param Filesystem $filesystem
     */
    public function __construct(
        FileIteratorFactory $fileIteratorFactory,
        Directory $directory,
        BundleManager $bundleManager,
        Filesystem $filesystem
    )
    {
        $this->directory = $directory;
        $this->bundleManager = $bundleManager;
        $this->filesystem = $filesystem;
        $this->fileIteratorFactory = $fileIteratorFactory;
    }

    /**
     * @param $type
     * @param $bundleName
     * @return mixed
     * @throws Exception
     */
    public function getModuleDir($type, $bundleName)
    {
        return $this->directory->getDirectory($bundleName, $type);
    }

    /**
     * @param $filename
     * @return mixed
     * @throws ReflectionException
     */
    public function getConfigurationFiles($filename)
    {
        return $this->getFilesIterator($filename, Directory::BUNDLE_CONFIG_DIR);
    }

    /**
     * @param $filename
     * @param string $subDirectory
     * @return mixed
     * @throws ReflectionException|Exception
     */
    private function getFilesIterator($filename, $subDirectory = '')
    {
        if (!isset($this->fileIterators[$subDirectory][$filename])) {
            $this->fileIterators[$subDirectory][$filename] = $this->fileIteratorFactory->create(
                $this->getFiles($filename, $subDirectory)
            );
        }
        return $this->fileIterators[$subDirectory][$filename];
    }

    /**
     * @param $filename
     * @param $subDirectory
     * @return array
     * @throws Exception
     */
    private function getFiles($filename, $subDirectory): array
    {
        $result = [];
        foreach($this->bundleManager->getNames() as $bundleName) {
            try {
                $bundleSubDir = $this->getModuleDir($subDirectory, $bundleName);
            } catch (\InvalidArgumentException $e) {
                continue;
            }

            $file = $bundleSubDir['path'] . '/' . $subDirectory . '/' . $filename;
            if($this->filesystem->exists($file)) {
                $result[] = $file;
            }
        }
        return $result;
    }
}