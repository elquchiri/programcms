<?php


namespace ElectroForums\UserBundle\Controller\Index;


class IndexController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    private \ElectroForums\UserBundle\Repository\UserRepository $customerRepository;

    public function __construct(
        \ElectroForums\RouterBundle\Service\Request $request,
        \ElectroForums\UserBundle\Repository\UserRepository $customerRepository
    )
    {
        parent::__construct($request);
        $this->customerRepository = $customerRepository;
    }

    public function execute()
    {
        $customer = $this->customerRepository->find(5);

        return $this->render('@ElectroForumsUser/adminhtml/list.html.twig', [

        ]);
    }
}