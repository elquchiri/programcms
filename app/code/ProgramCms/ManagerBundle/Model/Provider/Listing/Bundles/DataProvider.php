<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ManagerBundle\Model\Provider\Listing\Bundles;

use ProgramCms\CoreBundle\Model\DataObject;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 * @package ProgramCms\ManagerBundle\Model\Provider\Listing\Bundles
 */
class DataProvider extends AbstractDataProvider
{
    protected BundleManager $bundleManager;

    /**
     * DataProvider constructor.
     */
    public function __construct(
        BundleManager $bundleManager
    )
    {

        $this->bundleManager = $bundleManager;
    }

    public function getData(): mixed
    {
        $data = [];
        $bundles = $this->bundleManager->getAllBundles();
        foreach($bundles as $bundle) {
            $bundle['status'] = 'Active';
            $dataObject = new DataObject($bundle);
            $data[] = $dataObject;
        }
        return $data;
    }
}