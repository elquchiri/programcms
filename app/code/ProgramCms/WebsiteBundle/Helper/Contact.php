<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Helper;

use ProgramCms\CoreBundle\Helper\AbstractHelper;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;

/**
 * Class Contact
 * @package ProgramCms\WebsiteBundle\Helper
 */
class Contact extends AbstractHelper
{
    /**
     * @param string $type
     * @return mixed
     */
    public function getSenderEmail(string $type)
    {
        return $this->getConfig('email_addresses/' . $type .'/sender_email', ScopeInterface::SCOPE_WEBSITE_VIEW);
    }
}