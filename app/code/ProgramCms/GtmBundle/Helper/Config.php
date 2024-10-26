<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\GtmBundle\Helper;

use ProgramCms\CoreBundle\Helper\AbstractHelper;

/**
 * Class Config
 * @package ProgramCms\GtmBundle\Helper
 */
class Config extends AbstractHelper
{
    const GTM_ENABLED = 'gtm/general/enable';

    const GTM_CONTAINER_ID = 'gtm/general/container_id';

    /**
     * @return bool
     */
    public function isGtmEnabled(): bool
    {
        return (bool) $this->getConfig(self::GTM_ENABLED);
    }

    /**
     * @return string|null
     */
    public function getContainerId(): ?string
    {
        return $this->getConfig(self::GTM_CONTAINER_ID);
    }
}