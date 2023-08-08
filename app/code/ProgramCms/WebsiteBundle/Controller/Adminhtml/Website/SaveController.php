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
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Entity\Website;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;

/**
 * Class SaveWebsiteRootController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\SystemWebsite
 */
class SaveController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var Url
     */
    protected Url $url;
    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param Url $url
     * @param WebsiteRepository $websiteRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        Url $url,
        WebsiteRepository $websiteRepository,
        WebsiteGroupRepository $websiteGroupRepository,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->url = $url;
        $this->websiteRepository = $websiteRepository;
        $this->objectManager = $objectManager;
        $this->websiteGroupRepository = $websiteGroupRepository;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if($request->getMethod() == 'POST') {
            $formData = $request->request->all();
            $websiteId = $formData['id'] ?? "";

            /** @var Website $website */
            $website = $this->websiteRepository->findOneBy(['website_id' => $websiteId]);
            if(!$website) {
                $website = $this->objectManager->create(Website::class);
            }

            // Populate WebsiteRoot Entity
            foreach($formData as $name => $value) {
                if($name != 'id') {
                    if($website->hasDataUsingMethod($name)) {
                        $website->setDataUsingMethod($name, $value);
                    }
                }
                // Default Website
                if(isset($formData['default_website_group_id'])) {
                    $websiteGroup = $this->websiteGroupRepository->findOneBy(['website_group_id' => $formData['default_website_group_id']]);
                    $website->setDefaultGroup($websiteGroup);
                }
            }

            // Save WebsiteRoot
            $this->websiteRepository->save($website, true);

            // Flash success message
            $this->addFlash('success', 'Website Successfully Saved.');

            return $this->redirect($this->url->getUrlByRouteName('website_website_edit', ['id' => $website->getWebsiteId()]));
        }
        // Flash error message
        $this->addFlash('danger', 'Error Saving Website Data, please try again.');
        return $this->redirectToRoute('adminhtml_config_systemconfig_index');
    }
}