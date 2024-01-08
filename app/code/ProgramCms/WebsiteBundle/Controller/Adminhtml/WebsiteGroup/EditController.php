<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteGroup;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;

/**
 * Class EditController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteGroup
 */
class EditController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;

    /**
     * EditController constructor.
     * @param Context $context
     * @param WebsiteGroupRepository $websiteGroupRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        WebsiteGroupRepository $websiteGroupRepository,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->websiteGroupRepository = $websiteGroupRepository;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $websiteGroup = $this->websiteGroupRepository->findOneBy(['website_group_id' => $this->getRequest()->getParam('id')]);
        $pageResult->getConfig()->getTitle()->set(
            sprintf("%s : %s", $this->trans('Edit Group'), $websiteGroup->getWebsiteGroupName())
        );

        return $pageResult;
    }
}