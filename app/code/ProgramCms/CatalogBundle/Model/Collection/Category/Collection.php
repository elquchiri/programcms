<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Model\Collection\Category;

use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package ProgramCms\CatalogBundle\Model\Collection\Category
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize Collection
     */
    protected function _construct()
    {
        $this->_initEntity(CategoryEntity::class);
    }
}