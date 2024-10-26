<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteGroup;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ProgramCms\WebsiteBundle\Entity\WebsiteGroup;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;

/**
 * Class SaveController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteGroup
 */
class SaveController extends AdminController
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;

    /**
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param Url $url
     * @param WebsiteGroupRepository $websiteGroupRepository
     * @param ObjectManager $objectManager
     * @param ObjectSerializer $objectSerializer
     */
    public function __construct(
        Context $context,
        Url $url,
        WebsiteGroupRepository $websiteGroupRepository,
        ObjectManager $objectManager,
        ObjectSerializer $objectSerializer
    )
    {
        parent::__construct($context);
        $this->url = $url;
        $this->objectManager = $objectManager;
        $this->websiteGroupRepository = $websiteGroupRepository;
        $this->objectSerializer = $objectSerializer;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if($request->getMethod() == 'POST') {
            $formData = $request->request->all();
            $websiteGroupId = $formData['website_group_id'] ?? "";

            /** @var WebsiteGroup $websiteGroup */
            $websiteGroup = $this->websiteGroupRepository->findOneBy(['website_group_id' => $websiteGroupId]);
            if(!$websiteGroup) {
                $websiteGroup = $this->objectManager->create(WebsiteGroup::class);
            }

            $this->objectSerializer->arrayToObject($websiteGroup, $formData);

            // Save WebsiteRoot
            $this->websiteGroupRepository->save($websiteGroup, true);

            // Flash success message
            $this->addFlash('success', $this->trans('Website Group Successfully Saved.'));

            return $this->redirect($this->url->getUrlByRouteName('website_websitegroup_edit', ['id' => $websiteGroup->getWebsiteGroupId()]));
        }
        // Flash error message
        $this->addFlash('danger', 'Error Saving Website Group Data, please try again.');
        return $this->redirectToRoute('adminhtml_website_website_index');
    }
}