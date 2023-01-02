<?php


namespace ElectroForums\WebsiteBundle\Controller\Adminhtml;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebsiteController extends AbstractController
{

    #[Route('/admin/website/list', name: 'electro_forums_website_list')]
    public function websiteList(

    ): Response
    {

        return $this->render('@ElectroForumsWebsite/adminhtml/list.html.twig', [

        ]);
    }
}