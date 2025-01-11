<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdsenseBundle\Helper;

use ProgramCms\CoreBundle\Helper\AbstractHelper;

/**
 * Class Config
 * @package ProgramCms\AdsenseBundle\Helper
 */
class Config extends AbstractHelper
{
    const GOOGLE_ADSENSE_ENABLED = 'google_adsense/general/enable';

    const GOOGLE_ADSENSE_CLIENT_ID = 'google_adsense/general/client_id';

    /**
     * @return bool
     */
    public function isGoogleAdsenseEnabled(): bool
    {
        return (bool) $this->getConfig(self::GOOGLE_ADSENSE_ENABLED);
    }

    /**
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->getConfig(self::GOOGLE_ADSENSE_CLIENT_ID);
    }
}