<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Model\Provider\Listing\Role;

use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use ProgramCms\AclBundle\Model\ResourceModel\Role\Collection;

/**
 * Class DataProvider
 * @package ProgramCms\AclBundle\Model\Provider\Listing\Role
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
}