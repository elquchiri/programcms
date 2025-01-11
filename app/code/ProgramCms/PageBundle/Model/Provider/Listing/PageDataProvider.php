<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Model\Provider\Listing;

use ProgramCms\PageBundle\Model\Collection\PageCollection;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;

/**
 * Class PageDataProvider
 * @package ProgramCms\PageBundle\Model\Provider\Listing
 */
class PageDataProvider extends AbstractDataProvider
{
    /**
     * PageDataProvider constructor.
     * @param PageCollection $collection
     */
    public function __construct(
        PageCollection $collection
    )
    {
        $this->collection = $collection;
    }
}