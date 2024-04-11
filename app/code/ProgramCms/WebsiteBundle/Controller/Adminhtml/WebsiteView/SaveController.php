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
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class SaveController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteView
 */
class SaveController extends \ProgramCms\CoreBundle\Controller\AdminController
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
     * SaveController constructor.
     * @param Context $context
     * @param Url $url
     * @param WebsiteViewRepository $websiteViewRepository
     * @param WebsiteGroupRepository $websiteGroupRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        Url $url,
        WebsiteViewRepository $websiteViewRepository,
        WebsiteGroupRepository $websiteGroupRepository,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->url = $url;
        $this->websiteViewRepository = $websiteViewRepository;
        $this->objectManager = $objectManager;
        $this->websiteGroupRepository = $websiteGroupRepository;
    }

    /**
     * @return RedirectResponse
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if($request->getMethod() == 'POST') {
            $formData = $request->request->all();
            $websiteViewId = $formData['website_view_id'] ?? "";

            /** @var WebsiteView $websiteView */
            $websiteView = $this->websiteViewRepository->findOneBy(['website_view_id' => $websiteViewId]);
            if(!$websiteView) {
                $websiteView = $this->objectManager->create(WebsiteView::class);
            }
            // Populate WebsiteView Entity
            foreach($formData as $name => $value) {
                if($name === 'website_view_id' && empty($websiteViewId)) {
                    continue;
                }
                if($name == 'website_group_id') {
                    $websiteGroup = $this->websiteGroupRepository->findOneBy(['website_group_id' => $value]);
                    if($websiteGroup) {
                        $websiteView->setWebsiteGroup($websiteGroup);
                    }
                    continue;
                }
                if($websiteView->hasDataUsingMethod($name)) {
                    $websiteView->setDataUsingMethod($name, $value);
                }
            }

            // Save WebsiteRoot
            $this->websiteViewRepository->save($websiteView, true);

            // Flash success message
            $this->addFlash('success', $this->trans('Website View Successfully Saved.'));

            return $this->redirect($this->url->getUrlByRouteName('website_websiteview_edit', ['id' => $websiteView->getWebsiteViewId()]));
        }
        // Flash error message
        $this->addFlash('danger', 'Error Saving Website View Data, please try again.');
        return $this->redirectToRoute('adminhtml_website_website_index');
    }
}