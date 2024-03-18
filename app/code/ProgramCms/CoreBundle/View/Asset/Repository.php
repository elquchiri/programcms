<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Asset;

use Exception;
use ProgramCms\CoreBundle\View\Design\Theme\ThemeProviderInterface;
use ProgramCms\CoreBundle\View\DesignInterface;

/**
 * Class Repository
 * @package ProgramCms\CoreBundle\View\Asset
 */
class Repository
{
    const FILE_ID_SEPARATOR = '@';

    /**
     * @var DesignInterface
     */
    protected DesignInterface $design;

    /**
     * @var array|null
     */
    private ?array $defaults = null;

    /**
     * @var ThemeProviderInterface
     */
    private ThemeProviderInterface $themeProvider;

    /**
     * Repository constructor.
     * @param DesignInterface $design
     * @param ThemeProviderInterface $themeProvider
     */
    public function __construct(
        DesignInterface $design,
        ThemeProviderInterface $themeProvider
    )
    {
        $this->design = $design;
        $this->themeProvider = $themeProvider;
    }

    /**
     * @param $fileId
     * @return array
     * @throws Exception
     */
    public static function extractBundle($fileId): array
    {
        if (!str_contains($fileId, self::FILE_ID_SEPARATOR)) {
            return ['', $fileId];
        }
        $parts = explode('/', $fileId, 2);
        $bundleName = explode(self::FILE_ID_SEPARATOR, $parts[0])[1];
        if (empty($bundleName)) {
            throw new Exception(
                sprintf(
                    'Scope separator "%s" cannot be used without scope identifier.',
                    self::FILE_ID_SEPARATOR
                )
            );
        }
        return [$bundleName, $parts[1]];
    }

    /**
     * @param array $params
     * @return $this
     */
    public function updateDesignParams(array &$params)
    {
        // Set area
        if (empty($params['area'])) {
            $params['area'] = $this->getDefaultParameter('area');
        }

        // Set Theme Model
        $theme = null;
        $area = $params['area'];

        if (!empty($params['themeId'])) {
            $theme = $params['themeId'];
        } elseif (isset($params['theme'])) {
            $theme = $params['theme'];
        } elseif (empty($params['themeModel']) && $area !== $this->getDefaultParameter('area')) {
            $theme = $this->design->getConfigurationDesignTheme($area);
        }

        if ($theme) {
            if (is_numeric($theme)) {
                $params['themeModel'] = $this->getThemeProvider()->getThemeById($theme);
            } else {
                $params['themeModel'] = $this->getThemeProvider()->getThemeByFullPath($area . '/' . $theme);
            }

            if (!$params['themeModel']) {
                throw new \UnexpectedValueException("Could not find theme '$theme' for area '$area'");
            }
        } elseif (empty($params['themeModel'])) {
            $params['themeModel'] = $this->getDefaultParameter('themeModel');
        }

        // Set module
        if (!array_key_exists('bundle', $params)) {
            $params['bundle'] = false;
        }

        // Set locale
        if (empty($params['locale'])) {
            $params['locale'] = $this->getDefaultParameter('locale');
        }
        return $this;
    }

    /**
     * @param $name
     * @return mixed
     */
    private function getDefaultParameter($name)
    {
        $this->defaults = $this->design->getDesignParams();
        return $this->defaults[$name];
    }

    /**
     * @return ThemeProviderInterface
     */
    public function getThemeProvider(): ThemeProviderInterface
    {
        return $this->themeProvider;
    }
}