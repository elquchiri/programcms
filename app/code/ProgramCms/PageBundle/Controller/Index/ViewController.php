<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Controller\Index;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\PageBundle\Repository\PageRepository;
use ReflectionException;

/**
 * Class ViewController
 * @package ProgramCms\PageBundle\Controller\Adminhtml\Index
 */
class ViewController extends Controller
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
     * ViewController constructor.
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
     * @return object
     * @throws ReflectionException
     */
    public function execute(): object
    {
        $pageId = $this->getRequest()->getParam('id');
        $page = $this->pageRepository->getByIdentifier($pageId);
        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set($page->getPageName());
        return $pageResult;
    }
}