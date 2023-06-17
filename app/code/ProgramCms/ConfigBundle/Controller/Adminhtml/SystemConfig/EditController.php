<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig;

/**
 * Class EditController
 * @package ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig
 */
class EditController extends \ProgramCms\ConfigBundle\Controller\Adminhtml\AbstractConfigController
{

    public function execute()
    {
        return $this->loadConfigurations();
    }
}