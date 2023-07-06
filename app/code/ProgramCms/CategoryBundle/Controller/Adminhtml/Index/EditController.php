<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CategoryBundle\Controller\Adminhtml\Index;

use ProgramCms\CategoryBundle\Repository\CategoryRepository;
use ProgramCms\CoreBundle\Model\ObjectManager;

/**
 * Class EditController
 * @package ProgramCms\CategoryBundle\Controller\Adminhtml\Index
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
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\RouterBundle\Service\Response $response,
        CategoryRepository $categoryRepository,
        ObjectManager $objectManager
    )
    {
        parent::__construct($request, $response);
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