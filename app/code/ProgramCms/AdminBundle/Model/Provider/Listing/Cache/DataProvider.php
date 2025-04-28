<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Model\Provider\Listing\Cache;

use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use ProgramCms\AdminBundle\Model\ResourceModel\Cache\Collection;

/**
 * Class DataProvider
 * @package ProgramCms\AdminBundle\Model\Provider\Listing\Cache
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * DataProvider constructor.
     * @param Collection $collection
     */
    public function __construct(
        Collection $collection
    )
    {
        $this->collection = $collection;
    }

    public function getData(): array
    {
        $collectionData = parent::getData();
        $data = [];
        foreach($collectionData as $cache) {
            $cache->setData('status', $cache->getStatus() === true ? '<span class="badge rounded-pill bg-success w-100 text-uppercase" style="font-size: 12px;">Enabled</span>' : '<span class="badge bg-danger float-end">Disabled</span>');
            $data[] = $cache;
        }
        return $data;
    }
}