<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Controller\Adminhtml\Index;

use ProgramCms\CoreBundle\Controller\AdminController;

/**
 * Class RenderController
 * @package ProgramCms\UiBundle\Controller\Adminhtml\Index
 */
class RenderController extends AdminController
{
    /**
     * Render Component
     * @return void
     */
    public function execute()
    {
        $component = $this->getRequest()->getParam('component');
    }
}