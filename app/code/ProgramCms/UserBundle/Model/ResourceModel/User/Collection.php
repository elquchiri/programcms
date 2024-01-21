<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\ResourceModel\User;

/**
 * Class Collection
 * @package ProgramCms\UserBundle\Model\ResourceModel\User
 */
class Collection extends \ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection
{
    /**
     * Initialize Collection
     */
    protected function _construct()
    {
        $this->_initEntity(\ProgramCms\UserBundle\Entity\User::class);
    }
}