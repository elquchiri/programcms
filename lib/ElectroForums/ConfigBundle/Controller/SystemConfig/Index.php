<?php


namespace ElectroForums\ConfigBundle\Controller\SystemConfig;


class Index extends \ElectroForums\ConfigBundle\Controller\AbstractConfigController
{

    public function execute()
    {
        return $this->loadConfigurations();
    }
}