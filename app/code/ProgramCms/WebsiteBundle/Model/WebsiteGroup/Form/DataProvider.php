<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\WebsiteGroup\Form;

use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use ProgramCms\WebsiteBundle\Model\Collection\WebsiteGroup\Collection;

/**
 * Class DataProvider
 * @package ProgramCms\WebsiteBundle\Model\WebsiteGroup\Form
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