<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Adminhtml\Index;

/**
 * Class IndexController
 * @package ProgramCms\UserBundle\Controller\Adminhtml\Index
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\Controller
{

    protected \ProgramCms\CoreBundle\View\Result\Page $page;
    private \ProgramCms\UserBundle\Repository\UserRepository $customerRepository;

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\UserBundle\Repository\UserRepository $customerRepository,
        \ProgramCms\RouterBundle\Service\Response $response,
        \ProgramCms\CoreBundle\View\Result\Page $page
    )
    {
        parent::__construct($request, $response);
        $this->customerRepository = $customerRepository;
        $this->page = $page;
    }

    public function execute()
    {
        $customer = $this->customerRepository->find(5);
        $pageResult = $this->page;
        $pageResult->getConfig()->getTitle()->set("Users");
        return $pageResult->render();
    }
}