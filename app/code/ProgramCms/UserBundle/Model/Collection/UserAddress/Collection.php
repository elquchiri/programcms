<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Collection\UserAddress;

use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;
use ProgramCms\UserBundle\Entity\Address\UserAddressEntity;

/**
 * Class Collection
 * @package ProgramCms\UserBundle\Model\Collection\UserAddress
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize Collection
     */
    protected function _construct()
    {
        $this->_initEntity(UserAddressEntity::class);
    }
}