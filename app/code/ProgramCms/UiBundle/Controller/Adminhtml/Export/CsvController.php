<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Controller\Adminhtml\Export;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;

/**
 * Class CsvController
 * @package ProgramCms\UiBundle\Controller\Adminhtml\Export
 */
class CsvController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * CsvController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
    }

    public function execute()
    {
        $filters = $this->getRequest()->getParam('filters');
        $layoutName = $this->getRequest()->getParam('layout');
        /** @var Page $page */
        $page = $this->objectManager->create(Page::class, ['currentLayout' => $layoutName]);
        $layout = $page->getLayout();
        dd($layout->getAllBlocks());
    }
}