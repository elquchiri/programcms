<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Block\Account;

use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Helper\Config;

/**
 * Class Navigation
 * @package ProgramCms\AdminBundle\Block\Account
 */
class Navigation extends \ProgramCms\CoreBundle\View\Element\Template
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
     * Navigation constructor.
     * @param Context $context
     * @param Url $url
     * @param array $data
     */
    public function __construct(
        Context $context,
        Url $url,
        Config $websiteConfig,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->url = $url;
        $this->websiteConfig = $websiteConfig;
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
     * @return mixed
     */
    public function getFrontendBaseUrl()
    {
        return $this->websiteConfig->getBaseUrl();
    }
}