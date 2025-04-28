<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ManagerBundle\Model\Provider\Listing\Bundles;

use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\ManagerBundle\Model\Collection\Bundle\Collection;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use ProgramCms\CoreBundle\Model\DataObject;

/**
 * Class DataProvider
 * @package ProgramCms\ManagerBundle\Model\Provider\Listing\Bundles
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * DataProvider constructor.
     * @param Collection $collection
     * @param BundleManager $bundleManager
     */
    public function __construct(
        Collection $collection,
        BundleManager $bundleManager
    )
    {
        $this->collection = $collection;
        $this->bundleManager = $bundleManager;
    }

    public function getData(): mixed
    {
        $collectionData = parent::getData();
        $data = [];
        foreach($collectionData as $bundle) {
            $bundle->setData('status_label', $bundle->getStatus() === true ? '<span class="badge rounded-pill bg-success w-100 text-uppercase" style="font-size: 12px;">Enabled</span>' : '<span class="badge bg-danger float-end">Disabled</span>');
            $data[] = $bundle;
        }
        return $data;
    }
}