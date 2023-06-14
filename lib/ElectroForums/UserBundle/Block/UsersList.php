<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\UserBundle\Block;

use Twig\Environment;

class UsersList extends \ElectroForums\CoreBundle\View\Element\Template
{
    protected \ElectroForums\UiBundle\Model\Element\Grid $grid;

    public function __construct(
        Environment $environment,
        \ElectroForums\UiBundle\Model\Element\Grid $grid
    )
    {
        parent::__construct($environment);
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

    public function getData(): array
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