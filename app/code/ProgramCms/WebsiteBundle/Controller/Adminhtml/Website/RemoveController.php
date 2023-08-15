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
 * Class NewWebsite
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteView
 */
class RemoveController extends \ProgramCms\CoreBundle\Controller\Controller
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
     * NewController constructor.
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
        $websiteId = $this->request->getParam('website_id');
        $website = $this->websiteRepository->findOneBy(['website_id' => $websiteId]);
        if($website) {
            $this->websiteRepository->remove($website, true);
            // Flash success message
            $this->addFlash('success', sprintf('Website %s Successfully Removed.', $website->getWebsiteName()));
        }

        return $this->redirectToRoute('adminhtml_website_website_index');
    }
}