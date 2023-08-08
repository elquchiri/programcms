<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Collection\Website;

/**
 * Class Collection
 * @package ProgramCms\WebsiteBundle\Model\Collection\RootWebsite
 */
class Collection extends \ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection
{
    /**
     * Initialize Collection
     */
    protected function _construct()
    {
        $this->_initEntity(\ProgramCms\WebsiteBundle\Entity\Website::class);
    }
}