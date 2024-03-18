<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Model\View;

use ProgramCms\CoreBundle\App\Config;
use ProgramCms\CoreBundle\App\State;
use ProgramCms\CoreBundle\View\Design\Theme\ThemeFactory;
use ProgramCms\CoreBundle\View\Design\ThemeInterface;
use ProgramCms\CoreBundle\View\DesignInterface;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;

/**
 * Class Design
 * @package ProgramCms\ThemeBundle\Model\View
 */
class Design implements DesignInterface
{
    /**
     * @var State
     */
    protected State $state;

    /**
     * @var ThemeInterface|null
     */
    protected ?ThemeInterface $theme = null;

    /**
     * @var array
     */
    protected array $themes;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @var ThemeFactory
     */
    protected ThemeFactory $themeFactory;

    /**
     * Design constructor.
     * @param State $state
     * @param Config $config
     * @param ThemeFactory $themeFactory
     * @param array $themes
     */
    public function __construct(
        State $state,
        Config $config,
        ThemeFactory $themeFactory,
        array $themes = []
    )
    {
        $this->state = $state;
        $this->themes = $themes;
        $this->config = $config;
        $this->themeFactory = $themeFactory;
    }

    /**
     * @return string
     */
    public function getArea()
    {
        return $this->state->getAreaCode();
    }

    /**
     * @param ThemeInterface $theme
     * @param null $area
     * @return DesignInterface
     */
    public function setDesignTheme($theme, $area = null)
    {
        if($theme instanceof ThemeInterface) {
            $this->theme = $theme;
        }else{
            $this->theme = $this->themeFactory->create($theme);
        }

        return $this;
    }

    /**
     * @param null $area
     * @param array $params
     * @return mixed|string|null
     */
    public function getConfigurationDesignTheme($area = null, array $params = [])
    {
        if (!$area) {
            $area = $this->getArea();
        }

        $theme = null;
        $websiteView = $params['website_view'] ?? null;

        if($this->isFrontendTheme($area)) {
            $theme = $this->config->getValue(
                self::FRONTEND_THEME_PATH_CONFIG,
                ScopeInterface::SCOPE_WEBSITE_VIEW,
                $websiteView
            );
        }
        elseif($area === self::BACKEND_AREA) {
            $theme = $this->config->getValue(
                self::BACKEND_THEME_PATH_CONFIG
            );
        }

        // TODO: define themes in services.yaml
        if (!$theme && isset($this->themes[$area])) {
            $theme = $this->themes[$area];
        }

        return $theme;
    }

    /**
     * @return $this|DesignInterface
     */
    public function setDefaultDesignTheme()
    {
        $this->setDesignTheme($this->getConfigurationDesignTheme());
        return $this;
    }

    /**
     * @return ThemeInterface|null
     */
    public function getDesignTheme()
    {
        return $this->theme;
    }

    /**
     * @param $area
     * @return bool
     */
    private function isFrontendTheme($area): bool
    {
        return $area === self::FRONTEND_AREA;
    }

    /**
     * @param ThemeInterface $theme
     * @return string|null
     */
    public function getThemePath(ThemeInterface $theme)
    {
        return $theme->getThemePath();
    }

    public function getLocale()
    {
        // TODO: Implement getLocale() method.
    }

    public function getDesignParams()
    {
        return [
            'area' => $this->getArea(),
            'themeModel' => $this->getDesignTheme(),
            'locale'     => $this->getLocale(),
        ];
    }
}