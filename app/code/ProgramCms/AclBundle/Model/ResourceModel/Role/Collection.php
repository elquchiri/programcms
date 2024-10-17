<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Model\ResourceModel\Role;

use ProgramCms\AclBundle\Entity\Role;
use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package ProgramCms\AclBundle\Model\ResourceModel\Role
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize Collection
     */
    protected function _construct()
    {
        $this->_initEntity(Role::class);
    }
}