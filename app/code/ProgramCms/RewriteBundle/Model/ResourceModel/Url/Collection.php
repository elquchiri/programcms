<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Model\ResourceModel\Url;

use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;
use ProgramCms\RewriteBundle\Entity\UrlRewrite;

/**
 * Class Collection
 * @package ProgramCms\RewriteBundle\Model\ResourceModel\Url
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize Collection
     */
    protected function _construct()
    {
        $this->_initEntity(UrlRewrite::class);
    }
}