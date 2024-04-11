<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\ResourceModel\User;

use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;
use ProgramCms\UserBundle\Entity\UserEntity;

/**
 * Class Collection
 * @package ProgramCms\UserBundle\Model\ResourceModel\User
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize Collection
     */
    protected function _construct()
    {
        $this->_initEntity(UserEntity::class);
    }
}