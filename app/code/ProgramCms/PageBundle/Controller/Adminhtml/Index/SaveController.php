<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Controller\Adminhtml\Index;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminBundle\Repository\AdminUserRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\PageBundle\Entity\PageEntity;
use ProgramCms\PageBundle\Repository\PageRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SaveController
 * @package ProgramCms\PageBundle\Controller\Adminhtml\Index
 */
class SaveController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var PageRepository
     */
    protected PageRepository $pageRepository;

    /**
     * @var AdminUserRepository
     */
    protected AdminUserRepository $adminUserRepository;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param PageRepository $pageRepository
     * @param AdminUserRepository $adminUserRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        PageRepository $pageRepository,
        AdminUserRepository $adminUserRepository
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->pageRepository = $pageRepository;
        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * @return JsonResponse
     */
    public function execute()
    {
        $pageId = $this->getRequest()->getParam('entity_id');
        $editorJson = $this->getRequest()->getParam('data');
        $title = $this->getRequest()->getParam('title');
        $html = $this->getRequest()->getParam('html');
        $css = $this->getRequest()->getParam('css');

        if(empty($title)) {
            return $this->json([
                'success' => false,
                'message' => $this->trans('Please give a title to the page.')
            ]);
        }

        if(!is_null($pageId) && !empty($pageId)) {
            /** @var PageEntity $page */
            $page = $this->pageRepository->getById($pageId);
        }else{
            /** @var AdminUser $user */
            $user = $this->getUser();
            $page = new PageEntity();
            $page->setUser($user);
        }

        $page
            ->setPageName($title)
            ->setPageContent($editorJson)
            ->setPageHtml($html)
            ->setPageCss($css)
            ->updateTimestamps();

        // Save Page
        $this->pageRepository->save($page);

        $this->addFlash('success', $this->trans('Page successfully saved.'));

        return $this->json([
            'success' => true,
            'redirect_url' => $this->getUrl()->getUrl('page_index_index')
        ]);
    }
}