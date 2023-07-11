<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Controller\Adminhtml\Category;

use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\Model\ObjectManager;

/**
 * Class EditController
 * @package ProgramCms\CatalogBundle\Controller\Adminhtml\Index
 */
class EditController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    public function __construct(
        \ProgramCms\CoreBundle\Controller\Context $context,
        CategoryRepository $categoryRepository,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->categoryRepository = $categoryRepository;
        $this->objectManager = $objectManager;
    }

    /**
     * @return mixed|object|null
     */
    public function execute()
    {
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $pageResult->getConfig()->getTitle()->set("Edit Category");
        return $pageResult;
    }
}