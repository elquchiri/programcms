<?php


namespace ElectroForums\ConfigBundle\Controller\SystemConfig;


class EditController extends \ElectroForums\ConfigBundle\Controller\AbstractConfigController
{

    public function execute()
    {
        return $this->loadConfigurations();
    }
}