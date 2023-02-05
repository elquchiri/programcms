<?php


namespace ElectroForums\ConfigBundle\Model;


class Config
{

    private $container;

    public function __construct(
        \App\Kernel $kernel
    )
    {
        $this->container = $kernel->getContainer();
    }

    public function getConfigValue($path) {
        // TODO: Get value's $path from core_config_data first, If not found there, get the defaultValue from bundle's config file
        return $this->container->getParameter('system_config')['tab']['id'];
    }
}