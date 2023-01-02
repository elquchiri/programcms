<?php


namespace ElectroForums\UserBundle\Controller\Adminhtml;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    #[Route('/admin/user/view/id/{id}', name: 'electro_forums_user_home')]
    public function view(
        \ElectroForums\UserBundle\Repository\UserRepository $customerRepository
    ): Response
    {
        $customer = $customerRepository->find(5);
        return $this->render('@ElectroForumsUser/adminhtml/profile/view.html.twig', [

        ]);
    }

    #[Route('/user/list', name: 'electroForumsUserList')]
    public function list(
        Request $request
    ): Response
    {
        return $this->render('@ElectroForumsUser/adminhtml/list.html.twig', [

        ]);
    }
}