<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\Website;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;

/**
 * Class EditController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\Website
 */
class EditController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * EditController constructor.
     * @param Context $context
     * @param WebsiteRepository $websiteRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        WebsiteRepository $websiteRepository,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $website = $this->websiteRepository->findOneBy(['website_id' => $this->getRequest()->getParam('id')]);
        if($website) {
            $pageResult->getConfig()->getTitle()->set(
                sprintf("%s : %s", $this->trans('Edit Website'), $website->getWebsiteName())
            );
        }

        return $pageResult;
    }
}