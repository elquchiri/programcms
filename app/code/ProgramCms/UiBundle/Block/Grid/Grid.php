<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Grid;

/**
 * Class Grid
 * @package ProgramCms\UiBundle\Block\Grid
 */
class Grid extends \ProgramCms\CoreBundle\View\Element\Template
{
    protected string $_template = "@ProgramCmsUiBundle/grid/grid.html.twig";

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
        $columns = $this->getData('columns');
        foreach($columns as $key => $column) {
            if($key == 'actionsColumn') {
                $this->grid->addColumn($column['label'], 'action');
            }else{
                $this->grid->addColumn($column['label']);
            }
        }
        return $this->grid->getColumns();
    }

    public function getRows(): array
    {
        $this->grid->populate([
            [
                ['label' => '5'],
                ['label' => 'Home Page'],
                ['label' => 'All Website Views'],
                ['label' => 'Mohamed E.'],
                ['label' => 'Enable']
            ],
            [
                ['label' => '6'],
                ['label' => '404 Not Found'],
                ['label' => 'All Website Views'],
                ['label' => 'Mohamed E.'],
                ['label' => 'Enable']
            ],
            [
                ['label' => '7'],
                ['label' => 'Privacy Policy'],
                ['label' => 'All Website Views'],
                ['label' => 'Mohamed E.'],
                ['label' => 'Enable']
            ],
            [
                ['label' => '8'],
                ['label' => 'About us'],
                ['label' => 'All Website Views'],
                ['label' => 'Mohamed E.'],
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
