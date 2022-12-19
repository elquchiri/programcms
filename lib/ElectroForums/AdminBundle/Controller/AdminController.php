<?php


namespace ElectroForums\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminController extends AbstractController
{

    #[Route('/admin', name: 'admin_home')]
    public function index(): Response
    {
        return $this->render('@ElectroForumsAdmin/adminhtml/home.html.twig', [
            //'arg' => $translator->trans("Hello Profile"),
        ]);
    }
}