<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Model\ResourceModel\AdminUser;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package ProgramCms\AdminBundle\Model\ResourceModel\AdminUser
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize Collection
     */
    protected function _construct()
    {
        $this->_initEntity(AdminUser::class);
    }
}