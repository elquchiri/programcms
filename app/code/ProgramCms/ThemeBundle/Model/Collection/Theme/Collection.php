<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Model\Collection\Theme;

use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;
use ProgramCms\ThemeBundle\Entity\Theme;

/**
 * Class Collection
 * @package ProgramCms\ThemeBundle\Model\Collection\Theme
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize Collection
     */
    protected function _construct()
    {
        $this->_initEntity(Theme::class);
    }
}