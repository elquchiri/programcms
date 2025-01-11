<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Controller\Adminhtml\Ajax;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\PageBundle\Entity\PageEntity;
use ProgramCms\PageBundle\Repository\PageRepository;

/**
 * Class LoadPageController
 * @package ProgramCms\PageBundle\Controller\Adminhtml\Ajax
 */
class LoadPageController extends AdminController
{
    /**
     * @var PageRepository
     */
    protected PageRepository $pageRepository;

    /**
     * LoadPageController constructor.
     * @param Context $context
     * @param PageRepository $pageRepository
     */
    public function __construct(
        Context $context,
        PageRepository $pageRepository
    )
    {
        parent::__construct($context);
        $this->pageRepository = $pageRepository;
    }

    public function execute()
    {
        $pageId = $this->getRequest()->getParam('page_id');
        if(is_null($pageId) || empty($pageId)) {
            return $this->json([
                'edit' => false
            ]);
        }

        /** @var PageEntity $page */
        $page = $this->pageRepository->getById($pageId);
        return $this->json([
            'edit' => true,
            'title' => $page->getPageName(),
            'data' => $page->getPageContent()
        ]);
    }
}