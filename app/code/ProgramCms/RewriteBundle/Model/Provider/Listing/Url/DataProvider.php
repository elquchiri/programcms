<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Model\Provider\Listing\Url;

use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use ProgramCms\RewriteBundle\Model\ResourceModel\Url\Collection;

/**
 * Class DataProvider
 * @package ProgramCms\RewriteBundle\Model\Provider\Listing\Url
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