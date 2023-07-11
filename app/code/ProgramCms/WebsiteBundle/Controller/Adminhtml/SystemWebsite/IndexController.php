<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\SystemWebsite;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml
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
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);

        $pageResult->getConfig()->getTitle()->set("Websites");
        return $pageResult;
    }
}