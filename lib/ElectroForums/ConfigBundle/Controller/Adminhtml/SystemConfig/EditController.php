<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ConfigBundle\Controller\Adminhtml\SystemConfig;

/**
 * Class EditController
 * @package ElectroForums\ConfigBundle\Controller\Adminhtml\SystemConfig
 */
class EditController extends \ElectroForums\ConfigBundle\Controller\Adminhtml\AbstractConfigController
{

    public function execute()
    {
        return $this->loadConfigurations();
    }
}