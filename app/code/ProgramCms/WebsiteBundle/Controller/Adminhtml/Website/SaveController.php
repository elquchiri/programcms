<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\Website;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Entity\Website;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class SaveController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\Website
 */
class SaveController extends AdminController
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
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

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
        ObjectManager $objectManager,
        ObjectSerializer $objectSerializer
    )
    {
        parent::__construct($context);
        $this->url = $url;
        $this->websiteRepository = $websiteRepository;
        $this->objectManager = $objectManager;
        $this->objectSerializer = $objectSerializer;
    }

    /**
     * @return RedirectResponse
     * @throws \ReflectionException
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if($request->getMethod() == 'POST') {
            $formData = $request->request->all();
            $websiteId = $formData['website_id'] ?? "";

            /** @var Website $website */
            $website = $this->websiteRepository->findOneBy(['website_id' => $websiteId]);
            if(!$website) {
                $website = $this->objectManager->create(Website::class);
            }

            $this->objectSerializer->arrayToObject($website, $formData);

            // Save WebsiteRoot
            $this->websiteRepository->save($website);
            // Flash success message
            $this->addFlash('success', $this->trans('Website Successfully Saved.'));

            return $this->redirect($this->url->getUrlByRouteName('website_website_edit', ['id' => $website->getWebsiteId()]));
        }
        // Flash error message
        $this->addFlash('danger', $this->trans('Error Saving Website Data, please try again.'));
        return $this->redirectToRoute('adminhtml_website_website_index');
    }
}