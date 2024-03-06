<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\App\Config\Source;

use ProgramCms\CoreBundle\App\Config\ConfigSourceInterface;
use ProgramCms\CoreBundle\App\Config\Initial\Reader;
use ProgramCms\CoreBundle\Model\DataObject;

/**
 * Class BundleConfigSource
 * @package ProgramCms\ConfigBundle\App\Config\Source
 */
class BundledConfigSource implements ConfigSourceInterface
{
    /**
     * @var Reader
     */
    private Reader $reader;

    /**
     * BundledConfigSource constructor.
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Get initial config data from bundles
     * @param string $path
     * @return array|mixed
     */
    public function get($path = '')
    {
        $data = new DataObject($this->reader->read());
        if ($path !== '') {
            $path = '/' . $path;
        }
        return $data->getData('data' . $path) ?: [];
    }
}