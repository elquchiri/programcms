<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Controller\Adminhtml\Dashboard;

/**
 * Class IndexController
 * @package ProgramCms\AdminBundle\Controller\Adminhtml\Dashboard
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\Adminhtml\AbstractController
{

    public function execute()
    {
        return $this->getResponse()->render();
    }
}