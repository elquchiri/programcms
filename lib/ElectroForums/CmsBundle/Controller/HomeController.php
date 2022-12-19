<?php


namespace ElectroForums\CmsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{

    #[Route('/', name: 'frontend_home')]
    public function index(
        AuthenticationUtils $authenticationUtils
    ): Response
    {
        $lastEmail = $authenticationUtils->getLastUsername();

        return $this->render('@ElectroForumsCms/frontend/home.html.twig', [
            'email' => $lastEmail
        ]);
    }
}