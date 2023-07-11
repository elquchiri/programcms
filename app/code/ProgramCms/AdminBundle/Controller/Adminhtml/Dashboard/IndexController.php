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
class IndexController extends \ProgramCms\CoreBundle\Controller\Controller
{

    protected \ProgramCms\CoreBundle\Model\ObjectManager $objectManager;

    public function __construct(
        \ProgramCms\CoreBundle\Controller\Context $context,
        \ProgramCms\CoreBundle\Model\ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $pageResult->getConfig()->getTitle()->set("Dashboard");
        return $pageResult;
    }
}