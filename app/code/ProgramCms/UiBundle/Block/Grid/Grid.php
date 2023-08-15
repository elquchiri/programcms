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
        // Process Data
        foreach($data as $theme) {
            $row = [];
            foreach($this->getColumns() as $key => $value) {
                if(!in_array($key, ['actionsColumn', 'selectionsColumn'])) {
                    $row[$key] = $theme->getDataUsingMethod($key);
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
                $this->grid->addColumn($key, $column['label'], 'action');
            }else if($key == 'selectionsColumn') {
                $this->grid->addColumn($key, '');
            }else{
                $this->grid->addColumn($key, $column['label']);
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
        $this->grid->addAction([
            'label' => 'Visualize',
            'url' => '',
            'type' => 'url'
        ]);

        return $this->grid->getActions();
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return count($this->grid->getData());
    }
}
