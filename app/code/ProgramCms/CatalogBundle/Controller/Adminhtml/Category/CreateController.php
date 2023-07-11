<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Controller\Adminhtml\Category;

use ProgramCms\CatalogBundle\Repository\CategoryRepository;

/**
 * Class CreateController
 * @package ProgramCms\CatalogBundle\Controller\Adminhtml\Index
 */
class CreateController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    public function __construct(
        \ProgramCms\CoreBundle\Controller\Context $context,
        CategoryRepository $categoryRepository
    )
    {
        parent::__construct($context);
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return mixed|void
     */
    public function execute()
    {

    }
}