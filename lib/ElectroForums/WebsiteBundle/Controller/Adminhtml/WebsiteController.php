<?php


namespace ElectroForums\WebsiteBundle\Controller\Adminhtml;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebsiteController extends AbstractController
{

    private \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar;

    public function __construct(
        \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar
    )
    {
        $this->toolbar = $toolbar;
    }

    #[Route('/website/list', name: 'electro_forums_website_list')]
    public function websiteList(

    ): Response
    {
        $this->toolbar->addButton("Create Website View", "", "");
        $this->toolbar->addButton("Create Website", "", "");
        $this->toolbar->addButton("Create Root Website", "", "primary");

        return $this->render('@ElectroForumsWebsite/adminhtml/list.html.twig', [
            'buttons' => $this->toolbar->getButtons()
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