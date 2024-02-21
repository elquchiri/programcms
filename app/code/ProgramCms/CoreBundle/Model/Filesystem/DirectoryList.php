<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model\Filesystem;

use ProgramCms\CoreBundle\App\Kernel;

/**
 * Class DirectoryList
 * @package ProgramCms\CoreBundle\Model\Filesystem
 */
class DirectoryList
{
    /**
     * @var Kernel
     */
    protected Kernel $kernel;

    /**
     * DirectoryList constructor.
     * @param Kernel $kernel
     */
    public function __construct(
        Kernel $kernel
    )
    {
        $this->kernel = $kernel;
    }

    /**
     * @return string
     */
    public function getRoot(): string
    {
        return $this->kernel->getProjectDir();
    }
}