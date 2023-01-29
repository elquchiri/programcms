<?php


namespace ElectroForums\ConfigBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends AbstractController
{

    private \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar;

    public function __construct(
        \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar
    )
    {
        $this->toolbar = $toolbar;
    }

    #[Route('/system_config/index', name: 'admin_configuration')]
    public function index(): Response
    {
        $this->toolbar->addButton("Save Config", "", "primary");

        return $this->render('@ElectroForumsConfig/adminhtml/config.html.twig', [
            'buttons' => $this->toolbar->getButtons()
        ]);
    }
}