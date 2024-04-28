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
     * EditController constructor.
     * @param Context $context
     * @param CategoryRepository $categoryRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        CategoryRepository $categoryRepository,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context, $categoryRepository);
        $this->objectManager = $objectManager;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    public function execute()
    {
        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set("Edit Category");
        return $pageResult;
    }
}