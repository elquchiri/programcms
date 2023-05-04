<?php


namespace ElectroForums\ConfigBundle\Controller\Adminhtml\SystemConfig;


class EditController extends \ElectroForums\ConfigBundle\Controller\Adminhtml\AbstractConfigController
{

    public function execute()
    {
        return $this->loadConfigurations();
    }
}