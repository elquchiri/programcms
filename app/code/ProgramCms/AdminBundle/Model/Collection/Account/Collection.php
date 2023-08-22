<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Model\Collection\Account;

/**
 * Class Collection
 * @package ProgramCms\AdminBundle\Model\Collection\Account
 */
class Collection extends \ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection
{
    /**
     * Initialize Collection
     */
    protected function _construct()
    {
        $this->_initEntity(\ProgramCms\AdminBundle\Entity\AdminUser::class);
    }
}