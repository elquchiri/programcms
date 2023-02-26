<?php


namespace ElectroForums\ConfigBundle\Controller\SystemConfig;


class IndexController extends \ElectroForums\ConfigBundle\Controller\AbstractConfigController
{

    public function execute()
    {
        return $this->loadConfigurations();
    }
}