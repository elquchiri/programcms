<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CmsBundle\Controller\Adminhtml\Page;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;

/**
 * Class IndexController
 * @package ProgramCms\CmsBundle\Controller\Adminhtml\Page
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\AdminController
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
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        return $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
    }
}