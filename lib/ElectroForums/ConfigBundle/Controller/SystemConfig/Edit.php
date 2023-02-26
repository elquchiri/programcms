<?php


namespace ElectroForums\ConfigBundle\Controller\SystemConfig;


class Edit extends \ElectroForums\ConfigBundle\Controller\AbstractConfigController
{

    public function execute()
    {
        return $this->loadConfigurations();
    }
}