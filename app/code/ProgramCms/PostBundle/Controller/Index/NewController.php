<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Controller\Index;

use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ReflectionException;

/**
 * Class NewController
 * @package ProgramCms\PostBundle\Controller\Index
 */
class NewController extends Controller
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
     * NewController constructor.
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
        $categoryId = $this->getRequest()->getParam('category');
        $category = $this->categoryRepository->getById($categoryId);
        /** @var CategoryEntity $pageResult */
        $pageResult = $this->objectManager->create(Page::class);
        if($category) {
            $pageResult->getConfig()->getTitle()->set($category->getCategoryName());
        }
        return $pageResult;
    }
}