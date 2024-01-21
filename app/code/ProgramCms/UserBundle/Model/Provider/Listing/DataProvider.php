<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Listing;

use ProgramCms\UserBundle\Model\ResourceModel\User\Collection;

/**
 * Class DataProvider
 * @package ProgramCms\UserBundle\Model\Provider\Listing
 */
class DataProvider extends \ProgramCms\UiBundle\DataProvider\AbstractDataProvider
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