<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CmsBundle\Controller\Adminhtml\Page;

/**
 * Class IndexController
 * @package ProgramCms\CmsBundle\Controller\Adminhtml\Page
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var \ProgramCms\CoreBundle\Model\ObjectManager
     */
    protected \ProgramCms\CoreBundle\Model\ObjectManager $objectManager;

    public function __construct(
        \ProgramCms\CoreBundle\Controller\Context $context,
        \ProgramCms\CoreBundle\Model\ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
    }

    public function execute()
    {
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        return $pageResult;
    }
}