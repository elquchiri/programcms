<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Helper;

use ProgramCms\CoreBundle\App\Config as AppConfig;
use ProgramCms\CoreBundle\App\ScopeInterface;
use ProgramCms\CoreBundle\Helper\AbstractHelper;

/**
 * Class Config
 * @package ProgramCms\WebsiteBundle\Helper
 */
class Config extends AbstractHelper
{
    const WEBSITE_BASE_URL_PATH = 'web/urls/base_url';

    const LOCALE_CONFIG_PATH = 'general/locale_options/locale';

    /**
     * @var AppConfig
     */
    protected AppConfig $config;

    /**
     * Config constructor.
     * @param AppConfig $config
     */
    public function __construct(
        AppConfig $config
    )
    {
        $this->config = $config;
    }

    /**
     * @param $scopeType
     * @param $scopeId
     * @return mixed
     */
    public function getBaseUrl($scopeType = ScopeInterface::SCOPE_DEFAULT, $scopeId = 0)
    {
        return $this->config->getValue(
            self::WEBSITE_BASE_URL_PATH, $scopeType, $scopeId
        );
    }

    /**
     * @param string $scopeType
     * @param $scopeId
     * @return mixed
     */
    public function getLocale(string $scopeType = ScopeInterface::SCOPE_DEFAULT, $scopeId = 0)
    {
        return $this->config->getValue(
            self::LOCALE_CONFIG_PATH, $scopeType, $scopeId
        );
    }
}