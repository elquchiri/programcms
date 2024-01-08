<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Component\Listing;

use Exception;

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
     * @return array|mixed
     * @throws Exception
     */
    public function getDataSourceData()
    {
        $data = [];
        $listingName = $this->getName();

        if ($this->hasData('dataSource')) {
            $dataProvider = $this->getContext()->getDataProvider($listingName);
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
