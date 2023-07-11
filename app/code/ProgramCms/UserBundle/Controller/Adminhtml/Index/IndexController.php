<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Adminhtml\Index;

/**
 * Class IndexController
 * @package ProgramCms\UserBundle\Controller\Adminhtml\Index
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\Controller
{

    protected \ProgramCms\CoreBundle\Model\ObjectManager $objectManager;
    private \ProgramCms\UserBundle\Repository\UserRepository $customerRepository;

    public function __construct(
        \ProgramCms\CoreBundle\Controller\Context $context,
        \ProgramCms\UserBundle\Repository\UserRepository $customerRepository,
        \ProgramCms\CoreBundle\Model\ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->customerRepository = $customerRepository;
        $this->objectManager = $objectManager;
    }

    public function execute()
    {
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $pageResult->getConfig()->getTitle()->set("All Users");
        return $pageResult;
    }
}