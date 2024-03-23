<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Helper;

use ProgramCms\CoreBundle\Helper\AbstractHelper;
use ProgramCms\CoreBundle\Helper\Context;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;

/**
 * Class Config
 * @package ProgramCms\UserBundle\Helper
 */
class Config extends AbstractHelper
{
    const REDIRECT_USER_CONFIG = 'user_configuration/login_options/redirect_user_after_login';

    /**
     * @var WebsiteManagerInterface
     */
    protected WebsiteManagerInterface $websiteManager;

    /**
     * Config constructor.
     * @param Context $context
     * @param WebsiteManagerInterface $websiteManager
     */
    public function __construct(
        Context $context,
        WebsiteManagerInterface $websiteManager
    )
    {
        parent::__construct($context);
        $this->websiteManager = $websiteManager;
    }

    /**
     * @return bool
     */
    public function shouldRedirectUserAfterLogin(): bool
    {
        $currentWebsite = $this->websiteManager->getWebsite();
        return (bool) $this->getConfig(
            self::REDIRECT_USER_CONFIG,
            ScopeInterface::SCOPE_WEBSITE,
            $currentWebsite
        );
    }
}