<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteView;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class SaveController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteView
 */
class SaveController extends AdminController
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
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param Url $url
     * @param WebsiteViewRepository $websiteViewRepository
     * @param ObjectManager $objectManager
     * @param ObjectSerializer $objectSerializer
     */
    public function __construct(
        Context $context,
        Url $url,
        WebsiteViewRepository $websiteViewRepository,
        ObjectManager $objectManager,
        ObjectSerializer $objectSerializer
    )
    {
        parent::__construct($context);
        $this->url = $url;
        $this->websiteViewRepository = $websiteViewRepository;
        $this->objectManager = $objectManager;
        $this->objectSerializer = $objectSerializer;
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

            $this->objectSerializer->arrayToObject($websiteView, $formData);

            // Save WebsiteRoot
            $this->websiteViewRepository->save($websiteView);

            // Flash success message
            $this->addFlash('success', $this->trans('Website view successfully saved.'));

            return $this->redirect($this->url->getUrlByRouteName('website_websiteview_edit', ['id' => $websiteView->getWebsiteViewId()]));
        }
        // Flash error message
        $this->addFlash('danger', 'Error Saving Website View Data, please try again.');
        return $this->redirectToRoute('adminhtml_website_website_index');
    }
}