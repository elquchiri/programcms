<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\WebsiteBundle\Model\WebsiteManager;
use ProgramCms\WebsiteBundle\Helper\Config as ConfigHelper;
use Symfony\Component\Intl\Locales;

/**
 * Class LocaleSwitcher
 * @package ProgramCms\WebsiteBundle\Block
 */
class LocaleSwitcher extends Template
{
    /**
     * @var WebsiteManager
     */
    protected WebsiteManager $websiteManager;

    /**
     * @var ConfigHelper
     */
    protected ConfigHelper $configHelper;

    /**
     * WebsiteSwitcher constructor.
     * @param Context $context
     * @param WebsiteManager $websiteManager
     * @param ConfigHelper $configHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        WebsiteManager $websiteManager,
        ConfigHelper $configHelper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->websiteManager = $websiteManager;
        $this->configHelper = $configHelper;
    }

    /**
     * @return array
     */
    public function getLocales(): array
    {
        $locales = [];
        $currentGroup = $this->websiteManager->getGroup();
        $currentWebsiteView = $this->websiteManager->getWebsiteView();
        $baseUrl = $this->configHelper->getBaseUrl();
        foreach($currentGroup->getWebsiteViews() as $websiteView) {
            if($currentWebsiteView === $websiteView) {
                continue;
            }

            $locale = $this->configHelper->getLocale(
                'website_view', $websiteView->getWebsiteViewId()
            );
            $countryCode = explode('_', $locale)[1];
            $locales[] = [
                'flag' => 'bundles/programcmswebsite/images/flags/' . $countryCode . '.png',
                'name' => Locales::getName(
                    $this->configHelper->getLocale(
                    'website_view', $websiteView->getWebsiteViewId()
                    )
                ),
                'url' => $this->configHelper->getBaseUrl(
                    'website_view', $websiteView->getWebsiteViewId()
                )
            ];
        }
        return $locales;
    }

    /**
     * @return array
     */
    public function getCurrentLocale(): array
    {
        $websiteView = $this->websiteManager->getWebsiteView();
        $locale = $this->configHelper->getLocale('website_view', $websiteView->getWebsiteViewId());
        $countryCode = explode('_', $locale)[1];
        return [
            'flag' => 'bundles/programcmswebsite/images/flags/' . $countryCode . '.png',
            'name' => Locales::getName(
                $this->configHelper->getLocale(
                    'website_view', $websiteView->getWebsiteViewId()
                )
            )
        ];
    }
}