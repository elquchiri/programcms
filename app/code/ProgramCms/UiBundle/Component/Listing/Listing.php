<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing;

use ProgramCms\CoreBundle\App\RequestInterface;
use ProgramCms\CoreBundle\View\Element\AbstractBlock;
use ProgramCms\UiBundle\Component\AbstractComponent;
use Exception;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class Listing
 * @package ProgramCms\UiBundle\Component\Listing
 */
class Listing extends AbstractComponent
{
    const NAME = 'listing';

    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/listing/listing.html.twig";

    protected \ProgramCms\RouterBundle\Service\Request $request;

    public function __construct(
        Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * @return array|mixed
     * @throws Exception
     */
    public function getDataSourceData()
    {
        $data = [];
        $listingName = $this->getName();

        if ($this->hasData('dataSource')) {
            $dataProvider = $this->getContext()->getDataProvider($listingName);
            $dataProvider->getData();
            $filters = $this->request->getParameters();
            $collection = $dataProvider->getCollection();

            // Filter Provided Data by primaryFieldName
            $primaryFieldName = $dataProvider->getPrimaryFieldName();
            $requestFieldName = $dataProvider->getRequestFieldName();
            if (!empty($requestFieldName)) {
                $entityId = (int)$this->request->getParam($requestFieldName);
                if (!empty($entityId)) {
                    $collection->addFieldToFilter($primaryFieldName, $entityId);
                }
            }

            /** @var Columns $columnBlocks */
            if(!empty($filters)) {
                $columnBlocks = $this->getChildBlock('columns');
                if ($columnBlocks) {
                    /** @var AbstractBlock $block */
                    foreach ($columnBlocks->getChildBlocks() as $block) {
                        $columnName = $block->getNameInLayout();
                        if ($block->hasData('filter') &&
                            isset($filters[$columnName . '_filter']) &&
                            !empty($filters[$columnName . '_filter'])
                        ) {
                            $collection
                                ->addFieldToFilter($columnName, $filters[$columnName . '_filter']);
                        }
                    }
                }
            }

            $data = $collection->getData();
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getComponentName()
    {
        return self::NAME;
    }
}
