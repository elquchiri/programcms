<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model\Filesystem;

/**
 * Class DirectoryList
 * @package ProgramCms\CoreBundle\Model\Filesystem
 */
class DirectoryList
{
    protected \ProgramCms\CoreBundle\App\Kernel $kernel;

    public function __construct(
        \ProgramCms\CoreBundle\App\Kernel $kernel
    )
    {
        $this->kernel = $kernel;
    }

    public function getRoot(): string
    {
        return $this->kernel->getProjectDir();
    }
}