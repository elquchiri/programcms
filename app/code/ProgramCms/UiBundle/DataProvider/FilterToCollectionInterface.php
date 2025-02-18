<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\DataProvider;

use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;

/**
 * Interface FilterToCollectionInterface
 * @package ProgramCms\UiBundle\DataProvider
 */
interface FilterToCollectionInterface
{
    /**
     * @param AbstractCollection $collection
     * @param $field
     * @param $value
     * @return mixed
     */
    public function addFilter(AbstractCollection $collection, $field, $value);
}