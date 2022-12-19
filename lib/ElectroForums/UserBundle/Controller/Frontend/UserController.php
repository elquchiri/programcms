<?php


namespace ElectroForums\UserBundle\Controller\Frontend;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    #[Route('/user/edit', name: 'electro_forums_user_edit_dashboard')]
    public function dashboard(

    ): Response
    {
        return $this->render('@ElectroForumsUser/frontend/dashboard/dashboard.html.twig', [

        ]);
    }

    #[Route('/user/edit/informations', name: 'electro_forums_user_edit_informations')]
    public function editInformations(

    ): Response
    {
        return $this->render('@ElectroForumsUser/frontend/dashboard/edit.html.twig', [

        ]);
    }

    #[Route('/user/edit/password', name: 'electro_forums_user_edit_password')]
    public function editPassword(

    ): Response
    {
        return $this->render('@ElectroForumsUser/frontend/dashboard/password.html.twig', [

        ]);
    }
}