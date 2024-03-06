<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\Website;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;

/**
 * Class NewController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\Website
 */
class NewController extends \ProgramCms\CoreBundle\Controller\AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * NewController constructor.
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
        /** @var Page $pageResult */
        $pageResult = $this->objectManager->create(Page::class);

        $pageResult->getConfig()->getTitle()->set($this->translator->trans("New Website"));
        return $pageResult;
    }
}