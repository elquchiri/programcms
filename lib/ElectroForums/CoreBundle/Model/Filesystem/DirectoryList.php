<?php


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