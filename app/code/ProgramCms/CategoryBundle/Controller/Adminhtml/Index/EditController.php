<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CategoryBundle\Controller\Adminhtml\Index;


class EditController extends \ProgramCms\CoreBundle\Controller\Controller
{

    protected \ProgramCms\CoreBundle\Model\ObjectManager $objectManager;
    private $categoryRepository;

    public function __construct(
        \ProgramCms\CategoryBundle\Repository\CategoryRepository $categoryRepository,
        \ProgramCms\CoreBundle\Model\ObjectManager $objectManager
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->objectManager = $objectManager;
    }

    public function execute()
    {
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $pageResult->getConfig()->getTitle()->set("Edit Category");
        return $pageResult;
    }
}