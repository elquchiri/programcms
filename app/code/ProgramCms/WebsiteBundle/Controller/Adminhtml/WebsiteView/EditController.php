<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteView;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;

/**
 * Class NewRootWebsite
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteView
 */
class EditController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    protected WebsiteViewRepository $websiteViewRepository;

    /**
     * NewController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        WebsiteViewRepository $websiteViewRepository,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->websiteViewRepository = $websiteViewRepository;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $websiteView = $this->websiteViewRepository->findOneBy(['website_view_id' => $this->getRequest()->getParam('id')]);
        $pageResult->getConfig()->getTitle()->set(
            sprintf("Edit Website View: %s", $websiteView->getWebsiteViewName())
        );
        return $pageResult;
    }
}