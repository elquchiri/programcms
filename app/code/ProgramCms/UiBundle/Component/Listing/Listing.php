<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing;

use ProgramCms\CoreBundle\View\Element\AbstractBlock;
use ProgramCms\UiBundle\Component\AbstractComponent;
use ProgramCms\UiBundle\Component\Listing\Toolbar\Filters;
use ProgramCms\UiBundle\Component\Listing\Toolbar\MassActions;
use ProgramCms\UiBundle\Component\Listing\Toolbar\Pagination;
use ProgramCms\UiBundle\Component\Listing\Toolbar\Search;
use Exception;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class Listing
 * @package ProgramCms\UiBundle\Component\Listing
 */
class Listing extends AbstractComponent
{
    const NAME = 'listing';

    protected array $dateSourceData = [];

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/listing/listing.html.twig";

    /**
     * @return array|mixed
     * @throws Exception
     */
    public function getDataSourceData()
    {
        $listingName = $this->getName();

        if(!empty($this->dateSourceData)) {
            return $this->dateSourceData;
        }

        if ($this->hasData('dataSource')) {
            $dataProvider = $this->getContext()->getDataProvider($listingName);

            // Filter Provided Data by primaryFieldName
            $primaryFieldName = $dataProvider->getPrimaryFieldName();
            $requestFieldName = $dataProvider->getRequestFieldName();
            if (!empty($requestFieldName)) {
                $entityId = (int)$this->request->getParam($requestFieldName);
                if (!empty($entityId)) {
                    $dataProvider->addFilter($primaryFieldName, $entityId);
                }
            }

            if($this->getRequest()->hasParam('hidden_listing_filters')) {
                $filters = $this->getParams();
                $dataProvider->searchByFilters($filters);
            }

            if($this->getRequest()->hasParam('keyword_search')) {
                $keywordSearch = $this->getRequest()->getParam('keyword_search');
                if(!empty($keywordSearch)) {
                    $dataProvider->addFullTextSearch($keywordSearch);
                }
            }
            $this->dateSourceData = $dataProvider->getData();
        }

        return $this->dateSourceData;
    }

    private function getParams()
    {
        $filterParams = $this->request->getParameters();
        $filters = [];
        $columnBlocks = $this->getChildBlock($this->getName() . '_columns');
        if ($columnBlocks) {
            /** @var AbstractBlock $block */
            foreach ($columnBlocks->getChildBlocks() as $block) {
                $columnName = $block->getNameInLayout();
                if ($block->hasData('filter') &&
                    isset($filterParams[$columnName . '_filter']) &&
                    !empty($filterParams[$columnName . '_filter'])
                ) {
                    $filters[$columnName] = $filterParams[$columnName . '_filter'];
                }
            }
        }
        return $filters;
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getColumnsForKeywordSearch(): array
    {
        $columns = [];
        $layout = $this->getLayout();
        /** @var Columns $columnBlocks */
        $columnBlocks = $layout->getBlock($this->getName() . '_columns');
        $dataProvider = $this->getContext()->getDataProvider($this->getName());
        /** @var AbstractBlock $block */
        foreach($columnBlocks->getChildBlocks() as $block) {
            $column = $block->getNameInLayout();
            if(in_array($column, ['selectionsColumn', 'actionsColumn'])) {
                continue;
            }
            if(in_array($column, array_keys($dataProvider->getFilterStrategies()))) {
                continue;
            }

            $columns[] = $column;
        }

        return $columns;
    }

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    public function prepare()
    {
        parent::prepare();

        $filters = $this->getData('filters');
        $search = $this->getData('search');
        $pagination = $this->getData('pagination');
        $layout = $this->getLayout();

        /** @var Toolbar $toolbarBlock */
        $toolbarBlock = $layout->createBlock(
            Toolbar::class, $this->getName() . '_toolbar'
        );

        $filtersBlock = $layout->createBlock(
            Filters::class, $this->getName() . '_toolbar_filters'
        );

        $searchBlock = $layout->createBlock(
            Search::class, $this->getName() . '_toolbar_search'
        );
        $paginationBlock = $layout->createBlock(
            Pagination::class, $this->getName() . '_toolbar_pagination'
        );
        $massActions = $layout->createBlock(
            MassActions::class, $this->getName() . '_toolbar_massActions'
        );

        $toolbarBlock->setChild($this->getName() . '_toolbar_filters', $filtersBlock);
        $toolbarBlock->setChild($this->getName() . '_toolbar_search', $searchBlock);
        $toolbarBlock->setChild($this->getName() . '_toolbar_pagination', $paginationBlock);
        $toolbarBlock->setChild($this->getName() . '_toolbar_massActions', $massActions);

        $this->setChild($this->getName() . '_toolbar', $toolbarBlock);
    }
}
