<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Model\Provider\Listing\AdminUser;

use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use ProgramCms\AdminBundle\Model\ResourceModel\AdminUser\Collection;

/**
 * Class DataProvider
 * @package ProgramCms\AdminBundle\Model\Provider\Listing\AdminUser
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