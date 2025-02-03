<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CmsBundle\Controller\Index;

use ProgramCms\CmsBundle\Helper\Data;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\PageBundle\Entity\PageEntity;
use ProgramCms\PageBundle\Repository\PageRepository;

/**
 * Class IndexController
 * @package ProgramCms\CmsBundle\Controller\Index
 */
class IndexController extends Controller
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
     * IndexController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param PageRepository $pageRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        PageRepository $pageRepository
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->pageRepository = $pageRepository;
    }

    /**
     * Get home page content from dynamic pages
     * Fallback to the default layout
     * @return object|null
     */
    public function execute()
    {
        // Prepare Home CMS Page by Id & send content
        /** @var PageEntity $page */
        $page = $this->pageRepository->getByIdentifier(Data::DEFAULT_HOME_PAGE_IDENTIFIER);
        $args = is_null($page) ? [] : ['currentLayout' => 'page_index_view'];
        $title = is_null($page) ? $this->trans("Home Page") : $page->getPageName();

        /** @var Page $pageResult */
        $pageResult = $this->objectManager->create(Page::class, $args);
        $this->getRequest()->setParam("id", Data::DEFAULT_HOME_PAGE_IDENTIFIER);
        $pageResult->getConfig()->getTitle()->set(
            $title
        );

        return $pageResult;
    }
}