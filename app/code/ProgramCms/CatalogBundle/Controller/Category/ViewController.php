<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Controller\Category;

use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;

/**
 * Class ViewController
 * @package ProgramCms\CatalogBundle\Controller\Category
 */
class ViewController extends Controller
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
     * ViewController constructor.
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

    public function execute()
    {
        $categoryId = $this->getRequest()->getParam('id');
        $category = $this->categoryRepository->getById($categoryId);
        /** @var Page $pageResult */
        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set($category->getCategoryName());
        return $pageResult;
    }
}