<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteGroup;

/**
 * Class NewRootWebsite
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\SystemWebsite
 */
class NewController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var \ProgramCms\CoreBundle\Model\ObjectManager
     */
    protected \ProgramCms\CoreBundle\Model\ObjectManager $objectManager;

    /**
     * NewController constructor.
     * @param \ProgramCms\CoreBundle\Controller\Context $context
     * @param \ProgramCms\CoreBundle\Model\ObjectManager $objectManager
     */
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

        $pageResult->getConfig()->getTitle()->set("New Website Group");
        return $pageResult;
    }
}