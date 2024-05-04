<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Collection\WebsiteView;

use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;

/**
 * Class Collection
 * @package ProgramCms\WebsiteBundle\Model\Collection\WebsiteView
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize Collection
     */
    protected function _construct()
    {
        $this->_initEntity(WebsiteView::class);
        $this->addFieldToFilter('website_view_code', 'admin', 'neq');
    }
}