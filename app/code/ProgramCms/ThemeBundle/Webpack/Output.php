<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Webpack;

use Exception;
use ProgramCms\CoreBundle\App\Config;
use ProgramCms\CoreBundle\App\State;
use ProgramCms\WebsiteBundle\Model\State as WebsiteState;
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\ThemeBundle\Repository\ThemeRepository;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class Output
 * @package ProgramCms\ThemeBundle\Webpack
 */
class Output
{
    /**
     * Path where assets are bundled
     */
    const BUILD_PATH = '/build/';

    const APPLIED_THEME_CONFIG = 'theme_config/theme_configuration/applied_theme';

    const APPLIED_BACKEND_THEME_CONFIG = 'system/backend_theme/applied_theme';

    /**
     * @var State
     */
    protected State $state;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * @var ThemeRepository
     */
    protected ThemeRepository $themeRepository;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @var WebsiteState
     */
    private WebsiteState $websiteState;

    /**
     * Output constructor.
     * @param State $state
     * @param WebsiteState $websiteState
     * @param Request $request
     * @param ThemeRepository $themeRepository
     * @param Security $security
     * @param Config $config
     */
    public function __construct(
        State $state,
        WebsiteState $websiteState,
        Request $request,
        ThemeRepository $themeRepository,
        Security $security,
        Config $config
    )
    {
        $this->state = $state;
        $this->websiteState = $websiteState;
        $this->request = $request;
        $this->security = $security;
        $this->themeRepository = $themeRepository;
        $this->config = $config;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getCss(): string
    {
        return self::BUILD_PATH . $this->getAreaCode() . '/' . $this->getCurrentTheme() . '/app.css';
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getJs(): string
    {
        return self::BUILD_PATH . $this->getAreaCode() . '/' . $this->getCurrentTheme() . '/app.js';
    }

    /**
     * @return string
     */
    public function getAreaCode()
    {
        return $this->state->getAreaCode();
    }

    /**
     * @throws Exception
     */
    public function getCurrentTheme()
    {
        $runType = $this->state->getCurrentRunType();
        $runCode = $this->state->getCurrentRunCode();
        $currentWebsiteView = $this->websiteState->getCurrentWebsiteView($runType, $runCode);
        $websiteViewCode = $currentWebsiteView->getWebsiteViewCode();

        $themeId = $this->config->getValue(
            self::APPLIED_THEME_CONFIG,
            'website_view',
            $currentWebsiteView->getWebsiteViewId()
        );

        if($this->getAreaCode() === 'adminhtml') {
            $user = $this->security->getUser();
            if($user) {
                $websiteViewCode = $user->getInterfaceLocale();
            }
            $themeId = $this->config->getValue(
                self::APPLIED_BACKEND_THEME_CONFIG,
            );
        }

        $theme = $this->themeRepository->getById($themeId);

        return $theme->getThemePath() . '/' . $websiteViewCode;
    }
}