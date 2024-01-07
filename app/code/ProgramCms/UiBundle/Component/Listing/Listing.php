<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class Listing
 * @package ProgramCms\UiBundle\Component\Listing
 */
class Listing extends \ProgramCms\UiBundle\Component\AbstractComponent
{
    const NAME = 'listing';
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/listing/listing.html.twig";
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * Listing constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->objectManager = $objectManager;
    }

    /**
     * @return array|mixed
     */
    public function getDataSourceData()
    {
        $data = [];
        if ($this->hasData('dataSource')) {
            /** @var AbstractDataProvider $dataProvider */
            $dataProvider = $this->getContext()->getDataProvider();
            $data = $dataProvider->getData();

            // Filter Provided Data by primaryFieldName
            $primaryFieldName = $dataProvider->getPrimaryFieldName();
            $requestFieldName = $dataProvider->getRequestFieldName();
            if (!empty($requestFieldName)) {
                $entityId = (int)$this->request->getParam($requestFieldName);
                if (!empty($entityId)) {
                    $data = $dataProvider
                        ->getCollection()
                        ->filter(function ($entity) use ($entityId, $primaryFieldName) {
                            return $entity->getDataUsingMethod($primaryFieldName) === $entityId;
                        })->toArray();
                }
            }
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
