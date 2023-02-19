<?php


namespace ElectroForums\CmsBundle\Controller\Adminhtml;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{

    private \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar;
    private \ElectroForums\UiBundle\Model\Element\Grid $grid;

    public function __construct(
        \ElectroForums\UiBundle\Model\Element\Toolbar $toolbar,
        \ElectroForums\UiBundle\Model\Element\Grid $grid
    )
    {
        $this->toolbar = $toolbar;
        $this->grid = $grid;
    }

    #[Route('/cms/page', name: 'adminhtml_pages_list')]
    public function index(

    ): Response
    {
        $this->toolbar->addButton("Add New Page", "", "primary");

        $this->grid->addAction([
            'label' => 'Edit',
            'url' => '',
            'type' => 'dropdown',
            'actions' => [
                ['label' => 'Edit', 'url' => ''],
                ['label' => 'Lock', 'url' => '']
            ]
        ]);
        $this->grid->addAction([
            'label' => 'Delete',
            'url' => '',
            'type' => 'url'
        ]);

        $this->grid->addColumn('')
            ->addColumn('ID')
            ->addColumn('Title')
            ->addColumn('URL Key')
            ->addColumn('Website View')
            ->addColumn('Status')
            ->addColumn('Action', 'action');
        $this->grid->populate([
            [
                ['label' => '5'],
                ['label' => 'Home Page'],
                ['label' => 'home'],
                ['label' => 'All Website Views'],
                ['label' => 'Enable']
            ],
            [
                ['label' => '6'],
                ['label' => '404 Not Found'],
                ['label' => 'no-route'],
                ['label' => 'All Website Views'],
                ['label' => 'Enable']
            ],
            [
                ['label' => '7'],
                ['label' => 'Privacy Policy'],
                ['label' => 'privacy-policy-cookie-restriction-mode'],
                ['label' => 'All Website Views'],
                ['label' => 'Enable']
            ],
            [
                ['label' => '8'],
                ['label' => 'About us'],
                ['label' => 'about-us'],
                ['label' => 'All Website Views'],
                ['label' => 'Enable']
            ]
        ]);

        return $this->render('@ElectroForumsCms/adminhtml/pages.html.twig', [
            'buttons' => $this->toolbar->getButtons(),
            'grid' => $this->grid->getColumns(),
            'data' => $this->grid->getData(),
            'actions' => $this->grid->getActions()
        ]);
    }
}