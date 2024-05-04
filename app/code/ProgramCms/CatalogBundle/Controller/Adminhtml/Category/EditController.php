<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Controller\Adminhtml\Category;

use Exception;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ReflectionException;

/**
 * Class EditController
 * @package ProgramCms\CatalogBundle\Controller\Adminhtml\Category
 */
class EditController extends AbstractCategoryController
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
     * EditController constructor.
     * @param Context $context
     * @param CategoryRepository $categoryRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        CategoryRepository $categoryRepository,
        ObjectManager $objectManager,
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     * @throws Exception
     */
    public function execute()
    {
        // We Set the current website view before setting the current category
        // So that way the EavEntityListener will have the correct website view
        if($websiteViewId = $this->getRequest()->getParam('website_view')) {
            $this->websiteManager->setCurrentWebsiteView($websiteViewId);
        }
        if(!$this->getRequest()->getParam('id')) {
            $this->getRequest()->setParam('id', $this->categoryRepository->getDefaultCategory()->getEntityId());
        }

        /** @var Page $pageResult */
        $pageResult = $this->objectManager->create(Page::class);
        $categoryId = $this->getRequest()->getParam('id');
        if($categoryId) {
            $category = $this->categoryRepository->getById($categoryId);
            $pageResult->getConfig()->getTitle()->set($category->getCategoryName());
        }
        $this->prepareLayout($pageResult);
        return $pageResult;
    }
}