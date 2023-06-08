<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\CmsBundle\Controller\Index;

/**
 * Class HomeController
 * @package ElectroForums\CmsBundle\Controller
 */
class IndexController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    public function execute()
    {
        // Prepare Home CMS Page by Id & send content
        return $this->getResponse()->render();
    }
}