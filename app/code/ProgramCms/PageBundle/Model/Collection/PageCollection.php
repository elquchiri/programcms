<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Model\Collection;

use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;
use ProgramCms\PageBundle\Entity\PageEntity;

/**
 * Class PageCollection
 * @package ProgramCms\PageBundle\Model\Collection
 */
class PageCollection extends AbstractCollection
{
    /**
     * Init Page Entity
     */
    protected function _construct()
    {
        $this->_initEntity(PageEntity::class);
    }
}