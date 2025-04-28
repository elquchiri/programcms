<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\UiBundle\Component\AbstractComponent;
use ProgramCms\UiBundle\View\Element\Context;
use ProgramCms\UiBundle\View\Element\UiComponentFactory;

/**
 * Class Columns
 * @package ProgramCms\UiBundle\Component\Listing
 */
class Columns extends AbstractComponent
{
    const NAME = 'columns';

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var UiComponentFactory
     */
    protected UiComponentFactory $uiComponentFactory;

    /**
     * Columns constructor.
     * @param Context $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        UiComponentFactory $uiComponentFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->objectManager = $context->getObjectManager();
        $this->uiComponentFactory = $uiComponentFactory;
    }

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    /**
     * Build Columns and Rows
     * @return string
     * @throws \ReflectionException
     */
    public function _toHtml(): string
    {
        $layout = $this->getLayout();
        $parentName = $this->getLayout()->getParentName($this->getNameInLayout());
        $parentBlock = $this->getLayout()->getBlock($parentName);
        $dataSourceData = $this->getContext()->getDataSourceData($parentBlock);

        $html = "<table class=\"table table-bordered table-striped table-hover mt-3 admin-table\"><thead class=\"table-dark\"><tr>";
        foreach($this->getChildBlocks() as $childBlock) {
            if($childBlock instanceof SelectionsColumn) {
                $html .= "<th>" . $childBlock->toHtml() . "</th>";
                continue;
            }
            $html .= "<th>" . $childBlock->getLabel() . "</th>";
        }
        $html .= "</tr></thead>";

        $html .= "<tbody>";
        foreach($dataSourceData as $rowData) {
            $html .= "<tr>";
            foreach ($this->getChildBlocks() as $childBlock) {
                $params = $this->processParameters($childBlock);

                if(!empty($params['source'])) {
                    $childName = $childBlock->getName();
                    if($childBlock->hasData('dataScope')) {
                        $childName = $childBlock->getData('dataScope');
                    }
                    $value = $rowData->hasData($childName)
                        ? $rowData->getData($childName)
                        : $rowData->getDataUsingMethod($childName);

                    $type = $params['type'];
                    if($type === 'column') {
                        $childBlock->setValue($value);
                        $html .= "<td>" . $childBlock->toHtml() . "</td>";
                    }else{
                        $columnType = $this->uiComponentFactory->create(
                            $type,
                            'inner.' . $childName,
                            array_merge_recursive($childBlock->getData(), ['value' => $value]),
                            $layout
                        );
                        $html .= "<td>" . $columnType->toHtml() . "</td>";
                        $layout->unsetBlock('inner.' . $childName);
                    }
                }
            }
            $html .= "</tr>";
        }
        $html .= "</tbody></table>";

        if(empty($dataSourceData)) {
            $html .= "<p class='text-center text-muted'>No records found.</p>";
        }

        return $html;
    }

    /**
     * @param Column $block
     * @return array
     */
    protected function processParameters(Column $block): array
    {
        return [
            'type' => $block->hasData('type') ? $block->getData('type') : 'column',
            'label' => $block->getData('label'),
            'source' => $block->hasData('source') ? $block->getData('source') : '',
        ];
    }
}