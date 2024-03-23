<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\GdprBundle\Helper;

use ProgramCms\CoreBundle\Helper\AbstractHelper;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;

/**
 * Class Config
 * @package ProgramCms\GdprBundle\Helper
 */
class Config extends AbstractHelper
{
    /**
     * GDPR active path
     */
    const GDPR_ACTIVE_CONFIG = 'gdpr/general/active';

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return (bool) $this->getConfig(self::GDPR_ACTIVE_CONFIG, ScopeInterface::SCOPE_WEBSITE_VIEW);
    }
}