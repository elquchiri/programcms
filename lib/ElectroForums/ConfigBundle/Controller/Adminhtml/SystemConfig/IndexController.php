<?php


namespace ElectroForums\ConfigBundle\Controller\Adminhtml\SystemConfig;


class IndexController extends \ElectroForums\ConfigBundle\Controller\Adminhtml\AbstractConfigController
{

    public function execute()
    {
        return $this->loadConfigurations();
    }
}