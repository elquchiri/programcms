<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CmsBundle\Controller\Index;

/**
 * Class HomeController
 * @package ProgramCms\CmsBundle\Controller
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\Controller
{

    public function execute()
    {
        // Prepare Home CMS Page by Id & send content
        return $this->getResponse()->render();
    }
}