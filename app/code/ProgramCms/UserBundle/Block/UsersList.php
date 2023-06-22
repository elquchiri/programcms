<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block;


class UsersList extends \ProgramCms\CoreBundle\View\Element\Template
{
    protected \ProgramCms\UiBundle\Model\Element\Grid $grid;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        \ProgramCms\UiBundle\Model\Element\Grid $grid,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->grid = $grid;
    }

    public function getColumns(): array
    {
        $this->grid->addColumn('')
            ->addColumn('ID')
            ->addColumn('Title')
            ->addColumn('URL Key')
            ->addColumn('Website View')
            ->addColumn('Status')
            ->addColumn('Action', 'action');

        return $this->grid->getColumns();
    }

    public function getRows(): array
    {
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

        return $this->grid->getData();
    }

    public function getActions(): array
    {
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

        return $this->grid->getActions();
    }
}