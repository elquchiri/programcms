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

/**
 * Class CreateController
 * @package ProgramCms\CatalogBundle\Controller\Adminhtml\Category
 */
class CreateController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * CreateController constructor.
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
     * @return void
     */
    public function execute()
    {

    }
}