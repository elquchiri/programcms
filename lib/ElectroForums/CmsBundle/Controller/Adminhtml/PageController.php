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

        $this->grid->addColumn('ID')
            ->addColumn('Title')
            ->addColumn('URL Key')
            ->addColumn('Website View')
            ->addColumn('Status')
            ->addColumn('Action');
        $this->grid->populate([
            [
                ['label' => '5'],
                ['label' => 'Home'],
                ['label' => 'home'],
                ['label' => 5],
                ['label' => 'Enable'],
                ['label' => 'Edit'],
            ]
        ]);

        return $this->render('@ElectroForumsCms/adminhtml/pages.html.twig', [
            'buttons' => $this->toolbar->getButtons(),
            'grid' => $this->grid->getColumns(),
            'data' => $this->grid->getData()
        ]);
    }
}