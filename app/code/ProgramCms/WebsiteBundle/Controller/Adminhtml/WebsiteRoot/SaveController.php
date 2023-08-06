<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteRoot;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Entity\WebsiteRoot;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteRootRepository;

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
     * @var WebsiteRootRepository
     */
    protected WebsiteRootRepository $websiteRootRepository;
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    protected WebsiteRepository $websiteRepository;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param Url $url
     * @param WebsiteRootRepository $websiteRootRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        Url $url,
        WebsiteRootRepository $websiteRootRepository,
        WebsiteRepository $websiteRepository,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->url = $url;
        $this->websiteRootRepository = $websiteRootRepository;
        $this->objectManager = $objectManager;
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
            $websiteRootId = $formData['id'] ?? "";

            /** @var WebsiteRoot $websiteRoot */
            $websiteRoot = $this->websiteRootRepository->findOneBy(['website_root_id' => $websiteRootId]);
            if(!$websiteRoot) {
                $websiteRoot = $this->objectManager->create(WebsiteRoot::class);
            }

            // Populate WebsiteRoot Entity
            foreach($formData as $name => $value) {
                if($name != 'id') {
                    if($websiteRoot->hasDataUsingMethod($name)) {
                        $websiteRoot->setDataUsingMethod($name, $value);
                    }
                }
                // Default Website
                if(isset($formData['default_website_id'])) {
                    $website = $this->websiteRepository->findOneBy(['website_id' => $formData['default_website_id']]);
                    $websiteRoot->setDefaultWebsite($website);
                }
            }

            // Save WebsiteRoot
            $this->websiteRootRepository->save($websiteRoot);

            // Flash success message
            $this->addFlash('success', 'Root Website Saved Succefully.');

            return $this->redirect($this->url->getUrlByRouteName('website_websiteroot_edit', ['id' => $websiteRoot->getWebsiteRootId()]));
        }
        // Flash error message
        $this->addFlash('danger', 'Error Saving Root Website Data, please try again.');
        return $this->redirectToRoute('adminhtml_config_systemconfig_index');
    }
}