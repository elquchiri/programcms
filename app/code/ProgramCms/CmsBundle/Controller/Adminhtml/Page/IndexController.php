<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CmsBundle\Controller\Adminhtml;

class IndexController extends \ProgramCms\CoreBundle\Controller\Adminhtml\AbstractController
{

    private \ProgramCms\UiBundle\Model\Element\Toolbar $toolbar;
    private \ProgramCms\UiBundle\Model\Element\Grid $grid;

    public function __construct(
        \ProgramCms\UiBundle\Model\Element\Toolbar $toolbar,
        \ProgramCms\UiBundle\Model\Element\Grid $grid
    )
    {
        $this->toolbar = $toolbar;
        $this->grid = $grid;
    }

    public function execute()
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