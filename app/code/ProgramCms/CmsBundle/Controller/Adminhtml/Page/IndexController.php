<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CmsBundle\Controller\Adminhtml\Page;

/**
 * Class IndexController
 * @package ProgramCms\CmsBundle\Controller\Adminhtml\Page
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\Controller
{

    public function execute()
    {
        return $this->getResponse()->render();
    }
}