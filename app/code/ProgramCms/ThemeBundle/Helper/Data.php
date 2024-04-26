<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Helper;

use ProgramCms\CoreBundle\Helper\AbstractHelper;
use ProgramCms\CoreBundle\Helper\Context;
use ProgramCms\ThemeBundle\Repository\ThemeRepository;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;

/**
 * Class Data
 * @package ProgramCms\ThemeBundle\Helper
 */
class Data extends AbstractHelper
{
    const APPLIED_THEME_CONFIG = 'theme_config/theme_configuration/applied_theme';

    const APPLIED_BACKEND_THEME_CONFIG = 'system/backend_theme/applied_theme';

    /**
     * @var WebsiteManagerInterface
     */
    protected WebsiteManagerInterface $websiteManager;

    /**
     * @var ThemeRepository
     */
    protected ThemeRepository $themeRepository;

    /**
     * Data constructor.
     * @param Context $context
     * @param WebsiteManagerInterface $websiteManager
     * @param ThemeRepository $themeRepository
     */
    public function __construct(
        Context $context,
        WebsiteManagerInterface $websiteManager,
        ThemeRepository $themeRepository
    )
    {
        parent::__construct($context);
        $this->websiteManager = $websiteManager;
        $this->themeRepository = $themeRepository;
    }

    /**
     * @return mixed
     */
    public function getAppliedTheme($websiteView = null)
    {
        $currentWebsiteView = $websiteView ?? $this->websiteManager->getWebsiteView();
        $themePath = $this->getConfig(
            self::APPLIED_THEME_CONFIG,
            'website_view',
            $currentWebsiteView->getWebsiteViewId()
        );
        return $this->themeRepository->getByThemePath($themePath);
    }

    /**
     * @return object|null
     */
    public function getAppliedBackendTheme()
    {
        $themePath = $this->getConfig(self::APPLIED_BACKEND_THEME_CONFIG);
        return $this->themeRepository->getByThemePath($themePath);
    }
}