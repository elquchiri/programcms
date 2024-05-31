<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Model\Collection;

use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;
use ProgramCms\PostBundle\Entity\PostEntity;

/**
 * Class Collection
 * @package ProgramCms\PostBundle\Model\Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize Post Collection
     */
    protected function _construct()
    {
        $this->_initEntity(PostEntity::class);
    }
}