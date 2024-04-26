<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class Columns
 * @package ProgramCms\UiBundle\Component\Listing
 */
class Columns extends \ProgramCms\UiBundle\Component\AbstractComponent
{
    const NAME = 'columns';

    /**
     * To change to make it dynamic
     * @var array|string[]
     */
    private array $formatters = [
        'text' => \ProgramCms\UiBundle\Model\Formatter\Text::class,
        'date' => \ProgramCms\UiBundle\Model\Formatter\Date::class
    ];

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * Columns constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->objectManager = $context->getObjectManager();
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
     */
    public function _toHtml(): string
    {
        $parentName = $this->getLayout()->getParentName($this->getNameInLayout());
        $parentBlock = $this->getLayout()->getBlock($parentName);
        $dataSourceData = $this->getContext()->getDataSourceData($parentBlock);

        $html = "<table class=\"table table-bordered table-striped table-hover mt-3 admin-table\"><thead class=\"table-dark\"><tr>";
        foreach($this->getChildBlocks() as $childBlock) {
            if($childBlock instanceof \ProgramCms\UiBundle\Component\Listing\SelectionsColumn) {
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
                    $type = $params['type'];
                    $typeObject = $this->objectManager->create($this->formatters[$type]);

                    $childName = $childBlock->getName();
                    if($childBlock->hasData('dataScope')) {
                        $childName = $childBlock->getData('dataScope');
                    }

                    $value = $rowData->hasData($childName)
                        ? $rowData->getData($childName)
                        : $rowData->getDataUsingMethod($childName);
                    $childBlock->setValue(
                        $typeObject->getValue($value)
                    );

                    if($childBlock instanceof \ProgramCms\UiBundle\Component\Listing\ActionsColumn) {
                        $childBlock->setValue($rowData->getDataUsingMethod($childName));
                    }
                    $html .= "<td>" . $childBlock->toHtml() . "</td>";
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
            'type' => $block->hasData('type') ? $block->getData('type') : 'text',
            'label' => $block->getData('label'),
            'source' => $block->hasData('source') ? $block->getData('source') : '',
        ];
    }
}