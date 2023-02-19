<?php


namespace ElectroForums\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminController extends AbstractController
{

    private \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar;

    public function __construct(
        \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar
    )
    {
        $this->toolbar = $toolbar;
    }

    #[Route('/admin', name: 'admin_home')]
    public function index(): Response
    {
        $this->toolbar->addButton("Reload Data", "", "primary");

        return $this->render('@ElectroForumsAdmin/adminhtml/home.html.twig', [
            'buttons' => $this->toolbar->getButtons()
        ]);
    }
}