<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\Fallback\Rule;

use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\CoreBundle\View\Design\ThemeInterface;

/**
 * Class Theme
 * @package ProgramCms\CoreBundle\View\Design\Fallback\Rule
 */
class Theme implements RuleInterface
{
    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * @var RuleInterface
     */
    protected RuleInterface $rule;

    /**
     * Theme constructor.
     * @param RuleInterface $rule
     * @param BundleManager $bundleManager
     */
    public function __construct(
        RuleInterface $rule,
        BundleManager $bundleManager
    )
    {
        $this->bundleManager = $bundleManager;
        $this->rule = $rule;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getPatternDirs(array $params)
    {
        if (!array_key_exists('theme', $params) || !$params['theme'] instanceof ThemeInterface) {
            throw new \InvalidArgumentException(
                'Parameter "theme" should be specified and should implement the theme interface.'
            );
        }
        $result = [];
        $theme = $params['theme'];
        unset($params['theme']);
        while ($theme) {
            if ($theme->getThemePath()) {
                $params['theme_dir'] = $this->bundleManager->getPath(
                    BundleManager::THEME,
                    $theme->getThemePath()
                );
                $params = $this->getThemePubStaticDir($theme, $params);
                $result = array_merge($result, $this->rule->getPatternDirs($params));
            }
            $theme = $theme->getParent();
        }
        return $result;
    }

    /**
     * @param ThemeInterface $theme
     * @param array $params
     * @return array
     */
    private function getThemePubStaticDir(ThemeInterface $theme, array $params = [])
    {
        if (empty($params['theme_pubstatic_dir'])
            && isset($params['file'])
            && pathinfo($params['file'], PATHINFO_EXTENSION) === 'css'
        ) {
            $params['theme_pubstatic_dir'] = ''
                . '/' . $theme->getArea() . '/' . $theme->getCode()
                . (isset($params['locale']) ? '/' . $params['locale'] : '');
        }

        return $params;
    }
}