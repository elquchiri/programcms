<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\NewsletterBundle\Helper;

use ProgramCms\CoreBundle\Helper\AbstractHelper;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;

/**
 * Class Data
 * @package ProgramCms\NewsletterBundle\Helper
 */
class Data extends AbstractHelper
{
    const ENABLE_NEWSLETTER_CONFIG = 'newsletter/general/enable';

    /**
     * @return bool
     */
    public function isNewsletterEnabled(): bool
    {
        return (bool) $this->getConfig(
            self::ENABLE_NEWSLETTER_CONFIG,
            ScopeInterface::SCOPE_WEBSITE_VIEW
        );
    }
}