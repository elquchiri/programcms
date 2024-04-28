<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Controller\Adminhtml\Category;

use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ReflectionException;

/**
 * Class AbstractCategoryController
 * @package ProgramCms\CatalogBundle\Controller\Adminhtml\Category
 */
abstract class AbstractCategoryController extends AdminController
{
    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * AbstractCategoryController constructor.
     * @param Context $context
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        Context $context,
        CategoryRepository $categoryRepository
    )
    {
        parent::__construct($context);
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return mixed
     * @throws \HttpResponseException
     * @throws ReflectionException
     */
    public function dispatch(): mixed
    {
        if(!$this->getRequest()->getParam('id')) {
            $this->getRequest()->setParam('id', $this->categoryRepository->getDefaultCategory()->getEntityId());
        }
        return parent::dispatch();
    }
}