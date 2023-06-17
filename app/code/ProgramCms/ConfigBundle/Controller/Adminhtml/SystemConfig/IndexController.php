<?php


namespace ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig;


class IndexController extends \ProgramCms\ConfigBundle\Controller\Adminhtml\AbstractConfigController
{

    public function execute()
    {
        return $this->loadConfigurations();
    }
}