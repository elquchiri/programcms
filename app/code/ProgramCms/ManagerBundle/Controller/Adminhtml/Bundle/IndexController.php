<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ManagerBundle\Controller\Adminhtml\Bundle;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManagerInterface;
use ProgramCms\CoreBundle\View\Result\Page;

/**
 * Class IndexController
 * @package ProgramCms\ManagerBundle\Controller\Adminhtml\Bundle
 */
class IndexController extends AdminController
{
    /**
     * @var ObjectManagerInterface
     */
    protected ObjectManagerInterface $objectManager;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
    }

    public function execute()
    {
        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->trans("Installed Bundles")
        );
        return $pageResult;
    }
}