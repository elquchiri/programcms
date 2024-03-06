<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Config;

/**
 * Class FileIteratorFactory
 * @package ProgramCms\CoreBundle\Config
 */
class FileIteratorFactory
{

    /**
     * @param $paths
     * @return FileIterator
     */
    public function create($paths)
    {
        return new FileIterator($paths);
    }
}