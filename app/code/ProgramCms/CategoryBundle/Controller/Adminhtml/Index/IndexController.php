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
class IndexController extends \ProgramCms\CoreBundle\Controller\Adminhtml\AbstractController
{
    protected \ProgramCms\CoreBundle\View\Result\Page $page;

    /**
     * IndexController constructor.
     * @param \ProgramCms\RouterBundle\Service\Request $request
     * @param \ProgramCms\RouterBundle\Service\Response $response
     */
    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\RouterBundle\Service\Response $response,
        \ProgramCms\CoreBundle\View\Result\Page $page
    )
    {
        parent::__construct($request, $response);
        $this->page = $page;
    }

    /**
     * @return mixed|string
     */
    public function execute()
    {
        return $this->page->render();
        //return $this->getResponse()->render();
    }
}