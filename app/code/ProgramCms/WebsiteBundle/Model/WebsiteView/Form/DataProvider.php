<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\WebsiteView\Form;

use ProgramCms\WebsiteBundle\Model\Collection\WebsiteView\Collection;

/**
 * Class DataProvider
 * @package ProgramCms\WebsiteBundle\Model\WebsiteView\Form
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