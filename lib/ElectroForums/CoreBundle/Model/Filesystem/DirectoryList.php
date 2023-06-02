<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\CoreBundle\Model\Filesystem;


class DirectoryList
{
    protected \Symfony\Component\HttpKernel\KernelInterface $kernel;

    public function __construct(
        \Symfony\Component\HttpKernel\KernelInterface $kernel
    )
    {
        $this->kernel = $kernel;
    }

    public function getRoot(): string
    {
        return $this->kernel->getProjectDir();
    }
}