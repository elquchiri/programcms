<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\UserBundle\Controller\Adminhtml\Index;


class IndexController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    private \ElectroForums\UserBundle\Repository\UserRepository $customerRepository;
    private \ElectroForums\RouterBundle\Service\Response $response;

    public function __construct(
        \ElectroForums\RouterBundle\Service\Request $request,
        \ElectroForums\UserBundle\Repository\UserRepository $customerRepository,
        \ElectroForums\RouterBundle\Service\Response $response
    )
    {
        parent::__construct($request);
        $this->customerRepository = $customerRepository;
        $this->response = $response;
    }

    public function execute()
    {
        $customer = $this->customerRepository->find(5);
        return $this->response->render();
    }
}