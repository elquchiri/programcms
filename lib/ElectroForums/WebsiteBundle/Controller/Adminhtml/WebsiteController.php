<?php


namespace ElectroForums\WebsiteBundle\Controller\Adminhtml;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebsiteController extends AbstractController
{

    #[Route('/website/list', name: 'electro_forums_website_list')]
    public function websiteList(

    ): Response
    {

        return $this->render('@ElectroForumsWebsite/adminhtml/list.html.twig', [

        ]);
    }

    #[Route('/website/create', name: 'electro_forums_website_create')]
    public function createWebsite(

    ): Response
    {

        return $this->render('@ElectroForumsWebsite/adminhtml/create_website.html.twig', [

        ]);
    }
}