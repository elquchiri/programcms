<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig;

use ProgramCms\ConfigBundle\Controller\Adminhtml\AbstractConfigController;

/**
 * Class EditController
 * @package ProgramCms\ConfigBundle\Controller\Adminhtml\SystemConfig
 */
class EditController extends AbstractConfigController
{
    /**
     * @return object|null
     */
    public function execute()
    {
        return $this->loadConfigurations();
    }
}