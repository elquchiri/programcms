<?php


namespace ElectroForums\WebsiteBundle\Controller\Frontend;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebsiteSwitcherController extends AbstractController
{

    #[Route('/website/switch/{id}', name: 'electro_forums_website_switcher')]
    public function websiteSwitcher(

    ): Response
    {

        return $this->render('@ElectroForumsWebsite/adminhtml/list.html.twig', [

        ]);
    }
}