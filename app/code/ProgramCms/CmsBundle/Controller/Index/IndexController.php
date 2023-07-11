<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CmsBundle\Controller\Index;

/**
 * Class HomeController
 * @package ProgramCms\CmsBundle\Controller
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\Controller
{

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
        // Prepare Home CMS Page by Id & send content
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);

        $pageResult->getConfig()->getTitle()->set("Home Page");
        return $pageResult;
    }
}