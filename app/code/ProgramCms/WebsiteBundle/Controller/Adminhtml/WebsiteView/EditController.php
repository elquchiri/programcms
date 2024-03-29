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
 * Class EditController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteView
 */
class EditController extends \ProgramCms\CoreBundle\Controller\AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var WebsiteViewRepository
     */
    protected WebsiteViewRepository $websiteViewRepository;

    /**
     * EditController constructor.
     * @param Context $context
     * @param WebsiteViewRepository $websiteViewRepository
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
            sprintf("%s : %s", $this->trans('Edit Website View'), $websiteView->getWebsiteViewName())
        );

        return $pageResult;
    }
}