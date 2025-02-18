<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing\Toolbar;

use ProgramCms\CoreBundle\App\Request\Request;
use ProgramCms\CoreBundle\View\Element\AbstractBlock;
use ProgramCms\UiBundle\Component\AbstractComponent;
use ProgramCms\UiBundle\Component\Listing\Columns;
use ProgramCms\UiBundle\View\Element\Context;
use ProgramCms\UiBundle\View\Element\UiComponentFactory;

/**
 * Class Filters
 * @package ProgramCms\UiBundle\Component\Listing\Toolbar
 */
class Filters extends AbstractComponent
{
    const NAME = 'filters';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/listing/toolbar/filters.html.twig";

    /**
     * @var UiComponentFactory
     */
    protected UiComponentFactory $uiComponentFactory;

    /**
     * Filters constructor.
     * @param Context $context
     * @param array $data
     * @param Request $request
     */
    public function __construct(
        Context $context,
        array $data = [],
    )
    {
        parent::__construct($context, $data);
        $this->uiComponentFactory = $context->getUiComponentFactory();
    }

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getColumns(): array
    {
        $filters = [];
        $layout = $this->getLayout();
        $listingName = substr($this->getName(), 0, -strlen('_toolbar_filters'));
        $columnsName = $listingName . '_columns';

        /** @var Columns $columnBlocks */
        $columnBlocks = $layout->getBlock($columnsName);
        /** @var AbstractBlock $block */
        foreach ($columnBlocks->getChildBlocks() as $block) {
            if ($block->hasData('filter')) {
                $inputType = $block->getData('filter');
                $inputName = $block->getNameInLayout() . '_filter';
                $blockType = $this->uiComponentFactory->create(
                    $inputType,
                    $inputName,
                    [
                        'value' => $this->getRequest()->getParam($inputName),
                        'sourceModel' => $block->getData('filterOptions')
                    ],
                    $layout
                );
                $this->setChild($inputName, $blockType);

                $filters[] = [
                    'name' => $inputName,
                    'label' => $block->getLabel(),
                    'input' => $blockType->toHtml()
                ];
            }
        }
        return $filters;
    }

    /**
     * @return bool
     */
    public function isFiltersActive(): bool
    {
        return $this->getRequest()->hasParam('hidden_listing_filters');
    }

    /**
     * @return string
     */
    public function getResetUrl(): string
    {
        return $this->getUrl('user_index_index');
    }

    /**
     * @return array
     */
    public function getCols(): array
    {
        $cols = [];
        $layout = $this->getLayout();
        $listingName = substr($this->getName(), 0, -strlen('_toolbar_filters'));
        $columnsName = $listingName . '_columns';
        /** @var Columns $columnBlocks */
        $columnBlocks = $layout->getBlock($columnsName);
        /** @var AbstractBlock $block */
        foreach ($columnBlocks->getChildBlocks() as $block) {
            $inputName = $block->getNameInLayout() . '_filter';
            $cols[] = [
                'name' => $inputName,
                'label' => $block->getLabel(),
            ];
        }
        return $cols;
    }
}