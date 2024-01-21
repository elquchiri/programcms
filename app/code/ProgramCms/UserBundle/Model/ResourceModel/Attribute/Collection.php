<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\ResourceModel\Attribute;

/**
 * Class Collection
 * @package ProgramCms\UserBundle\Model\ResourceModel\Attribute
 */
class Collection extends \ProgramCms\EavBundle\Model\ResourceModel\Attribute\Collection
{
    /**
     * @var string
     */
    protected string $_entityTypeCode = 'user';

    /**
     * @return string
     */
    protected function _getEntityTypeCode()
    {
        return $this->_entityTypeCode;
    }
}