<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Model\Provider;

use ProgramCms\PostBundle\Model\Collection\Collection;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;

/**
 * Class PostDataProvider
 * @package ProgramCms\PostBundle\Model\Provider
 */
class PostDataProvider extends AbstractDataProvider
{
    /**
     * PostDataProvider constructor.
     * @param Collection $collection
     */
    public function __construct(
        Collection $collection
    )
    {
        $this->collection = $collection;
    }
}