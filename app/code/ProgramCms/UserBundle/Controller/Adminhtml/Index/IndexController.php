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
class IndexController extends \ProgramCms\CoreBundle\Controller\Adminhtml\AbstractController
{

    private \ProgramCms\UserBundle\Repository\UserRepository $customerRepository;

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\UserBundle\Repository\UserRepository $customerRepository,
        \ProgramCms\RouterBundle\Service\Response $response
    )
    {
        parent::__construct($request, $response);
        $this->customerRepository = $customerRepository;
    }

    public function execute()
    {
        $customer = $this->customerRepository->find(5);
        return $this->getResponse()->render();
    }
}