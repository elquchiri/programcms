<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Grid;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;

/**
 * Class Grid
 * @package ProgramCms\UiBundle\Block\Grid
 */
class Grid extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/grid/grid.html.twig";
    /**
     * @var \ProgramCms\UiBundle\Model\Element\Grid
     */
    protected \ProgramCms\UiBundle\Model\Element\Grid $grid;
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * Grid constructor.
     * @param Context $context
     * @param \ProgramCms\UiBundle\Model\Element\Grid $grid
     * @param ObjectManager $objectManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        \ProgramCms\UiBundle\Model\Element\Grid $grid,
        ObjectManager $objectManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->grid = $grid;
        $this->objectManager = $objectManager;
    }

    protected function _prepareLayout()
    {
        $layout = $this->getLayout();

        // Data from DataProvider
        $data = [];
        $providedData = [];

        if($this->hasData('dataProvider')) {
            $config = $this->getData('dataProvider');
            /** @var AbstractDataProvider $dataProvider */
            $dataProvider = $this->objectManager->create($config['class']);
            $data = $dataProvider->getData();
            if(isset($config['primaryFieldName']) && isset($config['requestFieldName'])) {
                $entityId = (int) $this->request->getParam($config['requestFieldName']);
                if(!empty($entityId)) {
                    $data = $dataProvider
                        ->getCollection()
                        ->filter(function ($entity) use ($entityId, $config) {
                            return $entity->getDataUsingMethod($config['primaryFieldName']) === $entityId;
                        })
                        ->current();
                }
            }
        }

        // Add Buttons
        if($this->hasData('buttons')) {
            $toolbarActions = $layout->createBlock(
                \ProgramCms\UiBundle\Block\Toolbar\ToolbarActions::class,
                'toolbar.actions',
                $this->getData('buttons')
            );
            $layout->setChild('buttons.bar', $toolbarActions->getNameInLayout());
            $toolbarActions->setLayout($layout);
        }

        // Process Data
        foreach($data as $theme) {
            $row = [];
            foreach($this->getColumns() as $key => $column) {
                if($key !== 'selectionsColumn') {
                    if(isset($column['class']) && !empty($column['class'])) {
                        $columnProvider = $this->objectManager->create($column['class']);
                        if($key === 'actionsColumn') {
                            $actions = $columnProvider->prepareData($theme);
                            $row[$key] = $this->_prepareActions($actions);
                            continue;
                        }
                        $row[$key] = $columnProvider->prepareData($theme);
                    }else{
                        $row[$key] = $theme->getDataUsingMethod($key);
                    }
                }
            }
            $providedData[] = $row;
        }

        // Populate Grid with data
        $this->grid->populate($providedData);
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        $columns = $this->getData('columns');
        foreach($columns as $key => $column) {
            if($key == 'actionsColumn') {
                $this->grid->addColumn($key, $column['label'], 'actions', $column['class'] ?? '');
            }else if($key == 'selectionsColumn') {
                $this->grid->addColumn($key, '');
            }else{
                $this->grid->addColumn($key, $column['label'], 'text', $column['class'] ?? '');
            }
        }
        return $this->grid->getColumns();
    }

    /**
     * @return array
     */
    public function getRows(): array
    {
        return $this->grid->getData();
    }

    /**
     * @return array
     */
    public function getActions(): array
    {
        return $this->grid->getActions();
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return count($this->grid->getData());
    }

    public function _prepareActions(array $actions)
    {
        $html = "";
        foreach($actions as $action) {
            $html .= "<a href=\"{$action['url']}\">{$action['label']}</a>";
        }

        return $html;
    }
}
