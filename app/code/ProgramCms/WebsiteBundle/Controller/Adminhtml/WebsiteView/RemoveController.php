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
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;

/**
 * Class RemoveController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteView
 */
class RemoveController extends \ProgramCms\CoreBundle\Controller\Controller
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
     * @var Url
     */
    protected Url $url;

    /**
     * NewController constructor.
     * @param Context $context
     * @param WebsiteViewRepository $websiteViewRepository
     * @param ObjectManager $objectManager
     * @param Url $url
     */
    public function __construct(
        Context $context,
        WebsiteViewRepository $websiteViewRepository,
        ObjectManager $objectManager,
        Url $url
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->websiteViewRepository = $websiteViewRepository;
        $this->url = $url;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $websiteViewId = $this->request->getParam('website_view_id');
        $websiteView = $this->websiteViewRepository->findOneBy(['website_view_id' => $websiteViewId]);
        if($websiteView) {
            $this->websiteViewRepository->remove($websiteView, true);
            // Flash success message
            $this->addFlash('success', sprintf('Website View %s Successfully Removed.', $websiteView->getWebsiteViewName()));
        }

        return $this->redirect(
            $this->url->getUrlByRouteName('website_websitegroup_edit', ['id' => $websiteView->getWebsiteGroup()->getWebsiteGroupId()])
        );
    }
}