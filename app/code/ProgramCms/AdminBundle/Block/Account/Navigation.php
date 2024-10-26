<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Block\Account;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ProgramCms\WebsiteBundle\Helper\Config;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class Navigation
 * @package ProgramCms\AdminBundle\Block\Account
 */
class Navigation extends Template
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var Config 
     */
    protected Config $websiteConfig;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * Navigation constructor.
     * @param Context $context
     * @param Url $url
     * @param Config $websiteConfig
     * @param Security $security
     * @param array $data
     */
    public function __construct(
        Context $context,
        Url $url,
        Config $websiteConfig,
        Security $security,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->url = $url;
        $this->websiteConfig = $websiteConfig;
        $this->security = $security;
    }

    /**
     * @return string
     */
    public function getAccountSettingsUrl(): string
    {
        return $this->url->getUrlByRouteName('admin_systemaccount_index');
    }

    /**
     * @return string
     */
    public function getLogoutUrl(): string
    {
        return $this->url->getUrlByRouteName('admin_systemaccount_logout');
    }

    /**
     * @return string|null
     */
    public function getFrontendBaseUrl(): ?string
    {
        return $this->websiteConfig->getBaseUrl();
    }

    /**
     * @return string
     */
    public function getAdminName(): string
    {
        /** @var AdminUser $user */
        $user = $this->security->getUser();
        return !empty($user->getFirstName()) ? $user->getFirstName() : $this->trans('Admin');
    }
}