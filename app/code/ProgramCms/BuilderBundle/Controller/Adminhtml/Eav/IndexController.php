<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\BuilderBundle\Controller\Adminhtml\Eav;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;

/**
 * Class IndexController
 * @package ProgramCms\BuilderBundle\Controller\Adminhtml\Eav
 */
class IndexController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
    }

    /**
     * @return object
     */
    public function execute(): object
    {
        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->trans("Entity Manager")
        );
        return $pageResult;
    }
}