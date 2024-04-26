<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Listing\UserLog;

use ProgramCms\UserBundle\Model\Collection\UserLog\Collection;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;

/**
 * Class DataProvider
 * @package ProgramCms\UserBundle\Model\Provider\Listing\UserLog
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