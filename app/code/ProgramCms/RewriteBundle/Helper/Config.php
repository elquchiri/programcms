<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Helper;

use ProgramCms\CoreBundle\Helper\AbstractHelper;

/**
 * Class Config
 * @package ProgramCms\RewriteBundle\Helper
 */
class Config extends AbstractHelper
{
    const REWRITE_ENABLED = 'url_rewrite/general/enable';

    /**
     * @return bool
     */
    public function isRewriteEnabled(): bool
    {
        return (bool) $this->getConfig(self::REWRITE_ENABLED);
    }
}