<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing;

/**
 * Class Columns
 * @package ProgramCms\UiBundle\Component\Listing
 */
class Columns extends \ProgramCms\UiBundle\Component\AbstractComponent
{
    const NAME = 'columns';

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
                if($childBlock->hasData('source')) {
                    $childName = $childBlock->getName();
                    if ($rowData->hasDataUsingMethod($childName)) {
                        $childBlock->setValue($rowData->getData($childName));
                    }
                    if($childBlock instanceof \ProgramCms\UiBundle\Component\Listing\ActionsColumn) {
                        $childBlock->setValue($rowData->getDataUsingMethod($childName));
                    }
                    $html .= "<td>" . $childBlock->toHtml() . "</td>";
                }
            }
            $html .= "</tr>";
        }
        $html .= "</tbody></table>";

        return $html;
    }
}