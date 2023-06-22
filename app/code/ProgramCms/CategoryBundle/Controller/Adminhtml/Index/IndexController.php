<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CategoryBundle\Controller\Adminhtml\Index;


class IndexController extends \ProgramCms\CoreBundle\Controller\Adminhtml\AbstractController
{

    public function execute()
    {
        return $this->getResponse()->render();
    }
}