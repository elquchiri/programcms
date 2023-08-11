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
use ProgramCms\WebsiteBundle\Entity\WebsiteGroup;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;

/**
 * Class SaveWebsiteRootController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteGroup
 */
class SaveController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var Url
     */
    protected Url $url;
    /**
     * @var WebsiteViewRepository
     */
    protected WebsiteViewRepository $websiteViewRepository;
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;
    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param Url $url
     * @param WebsiteViewRepository $websiteViewRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        Url $url,
        WebsiteViewRepository $websiteViewRepository,
        WebsiteGroupRepository $websiteGroupRepository,
        WebsiteRepository $websiteRepository,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->url = $url;
        $this->websiteViewRepository = $websiteViewRepository;
        $this->objectManager = $objectManager;
        $this->websiteGroupRepository = $websiteGroupRepository;
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if($request->getMethod() == 'POST') {
            $formData = $request->request->all();
            $websiteGroupId = $formData['id'] ?? "";

            /** @var WebsiteGroup $websiteGroup */
            $websiteGroup = $this->websiteGroupRepository->findOneBy(['website_group_id' => $websiteGroupId]);
            if(!$websiteGroup) {
                $websiteGroup = $this->objectManager->create(WebsiteGroup::class);
            }

            // Populate WebsiteRoot Entity
            foreach($formData as $name => $value) {
                // Group's WebsiteId
                if($name === 'website_id') {
                    $website = $this->websiteRepository->findOneBy(['website_id' => $value]);
                    if($website) {
                        $websiteGroup->setWebsite($website);
                    }
                    continue;
                }
                // Default WebsiteView
                if($name === 'default_website_view_id') {
                    $websiteView = $this->websiteViewRepository->findOneBy(['website_view_id' => $value]);
                    if($websiteView) {
                        $websiteGroup->setDefaultWebsiteView($websiteView);
                    }
                    continue;
                }
                if($websiteGroup->hasDataUsingMethod($name)) {
                    $websiteGroup->setDataUsingMethod($name, $value);
                }
            }

            // Save WebsiteRoot
            $this->websiteGroupRepository->save($websiteGroup, true);

            // Flash success message
            $this->addFlash('success', 'Website Group Successfully Saved.');

            return $this->redirect($this->url->getUrlByRouteName('website_websitegroup_edit', ['id' => $websiteGroup->getWebsiteGroupId()]));
        }
        // Flash error message
        $this->addFlash('danger', 'Error Saving Website Group Data, please try again.');
        return $this->redirectToRoute('adminhtml_website_website_index');
    }
}