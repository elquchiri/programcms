<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CategoryBundle\Controller\Adminhtml\Index;

/**
 * Class IndexController
 * @package ProgramCms\CategoryBundle\Controller\Adminhtml\Index
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\Controller
{
    protected \ProgramCms\CoreBundle\Model\ObjectManager $objectManager;

    /**
     * IndexController constructor.
     * @param \ProgramCms\RouterBundle\Service\Request $request
     * @param \ProgramCms\RouterBundle\Service\Response $response
     */
    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\RouterBundle\Service\Response $response,
        \ProgramCms\CoreBundle\Model\ObjectManager $objectManager
    )
    {
        parent::__construct($request, $response);
        $this->objectManager = $objectManager;
    }

    /**
     * @return mixed|string
     */
    public function execute()
    {
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $pageResult->getConfig()->getTitle()->set("Default Category");
        return $pageResult;
    }
}