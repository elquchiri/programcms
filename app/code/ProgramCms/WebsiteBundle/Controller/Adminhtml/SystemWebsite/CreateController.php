<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\SystemWebsite;

/**
 * Class IndexController
 * @package ProgramCms\UserBundle\Controller\Adminhtml\Index
 */
class CreateController extends \ProgramCms\CoreBundle\Controller\Adminhtml\AbstractController
{

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\RouterBundle\Service\Response $response
    )
    {
        parent::__construct($request, $response);
    }

    public function execute()
    {
        return $this->getResponse()->render();
    }
}