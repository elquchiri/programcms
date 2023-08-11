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
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;

/**
 * Class NewRootWebsite
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteView
 */
class RemoveController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;
    protected Url $url;

    /**
     * NewController constructor.
     * @param Context $context
     * @param WebsiteGroupRepository $websiteGroupRepository
     * @param ObjectManager $objectManager
     * @param Url $url
     */
    public function __construct(
        Context $context,
        WebsiteGroupRepository $websiteGroupRepository,
        ObjectManager $objectManager,
        Url $url
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->websiteGroupRepository = $websiteGroupRepository;
        $this->url = $url;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $websiteGroupId = $this->request->getParam('website_group_id');
        $websiteGroup = $this->websiteGroupRepository->findOneBy(['website_group_id' => $websiteGroupId]);
        if($websiteGroup) {
            $this->websiteGroupRepository->remove($websiteGroup, true);
            // Flash success message
            $this->addFlash('success', sprintf('Website Group %s Successfully Removed.', $websiteGroup->getWebsiteGroupName()));
        }

        return $this->redirect(
            $this->url->getUrlByRouteName('website_website_edit', ['id' => $websiteGroup->getWebsite()->getWebsiteId()])
        );
    }
}