<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Controller\Adminhtml\Category;

use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;
use ReflectionException;

/**
 * Class IndexController
 * @package ProgramCms\CatalogBundle\Controller\Adminhtml\Category
 */
class IndexController extends AbstractCategoryController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        CategoryRepository $categoryRepository
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    public function execute()
    {
        if(!$this->getRequest()->getParam('id')) {
            $this->getRequest()->setParam('id', $this->categoryRepository->getDefaultCategory()->getEntityId());
        }
        $pageResult = $this->objectManager->create(Page::class);
        // Forward to EditController
        $this->forward('ProgramCms\CatalogBundle\Controller\Adminhtml\Category\EditController::execute');
        return $pageResult;
    }
}