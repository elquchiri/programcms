<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig;

/**
 * Class IndexController
 * @package ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig
 */
class IndexController extends \ProgramCms\ConfigBundle\Controller\Adminhtml\AbstractConfigController
{
    /**
     * @return object|null
     */
    public function execute()
    {
        return $this->loadConfigurations();
    }
}