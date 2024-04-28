<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model\Utils;

use Exception;
use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ReflectionException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BundleManager
 * @package ProgramCms\CoreBundle\Model\Utils
 */
class BundleManager
{
    const BUNDLE = 'bundle';

    const THEME = 'theme';

    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * BundleManager constructor.
     * @param ContainerInterface $container
     */
    public function __construct(
        ContainerInterface $container
    )
    {
        $this->container = $container;
    }

    /**
     * Get container instance
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * Get parameter from container
     * @param $parameter
     * @return array|bool|float|int|string|null
     */
    public function getContainerParameter($parameter)
    {
        return $this->container->getParameter($parameter);
    }

    /**
     * Get All registered ProgramCMS bundles
     * @return array
     * @throws ReflectionException
     */
    public function getAllBundles(): array
    {
        $bundles = [];
        foreach ($this->getContainerParameter('kernel.bundles') as $bundleName => $bundleClass) {
            $reflectedBundle = new \ReflectionClass($bundleClass);
            if ($reflectedBundle->isSubclassOf(ProgramCmsCoreBundle::class)) {
                $bundleDirectory = dirname($reflectedBundle->getFileName());
                $bundles[$bundleName] = [
                    'name' => $reflectedBundle->getShortName(),
                    'path' => $bundleDirectory
                ];
            }
        }

        return $bundles;
    }

    /**
     * Get bundle by name
     * @throws Exception
     */
    public function getBundleByName($bundleName)
    {
        $bundles = $this->getAllBundles();
        if(isset($bundles[$bundleName])) {
            return $bundles[$bundleName];
        }
        throw new Exception(sprintf("Invalid Bundle %s", $bundleName));
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getNames(): array
    {
        return array_keys($this->getAllBundles());
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getAllThemes(): array
    {
        $themes = [];
        foreach ($this->getContainerParameter('kernel.themes') as $themeName => $themeClass) {
            $reflectedTheme = new \ReflectionClass($themeClass);
            if ($reflectedTheme) {
                $themeDirectory = dirname($reflectedTheme->getFileName());
                $themes[$themeName] = [
                    'name' => $reflectedTheme->getShortName(),
                    'class' => $themeClass,
                    'path' => $themeDirectory
                ];
            }
        }

        return $themes;
    }

    /**
     * @param $themeName
     * @return mixed
     * @throws ReflectionException
     * @throws Exception
     */
    public function getThemeByName($themeName)
    {
        $themes = $this->getAllThemes();
        if(isset($themes[$themeName])) {
            return $themes[$themeName];
        }
        throw new Exception(sprintf("Invalid Theme %s", $themeName));
    }

    /**
     * @param string $bundleType
     * @param string $bundleName
     * @return string|null
     */
    public function getPath(string $bundleType, string $bundleName): ?string
    {
        return match ($bundleType) {
            self::BUNDLE => $this->getContainerParameter('kernel.bundles_metadata')[$bundleName]['path'] ?? null,
            self::THEME => $this->getContainerParameter('kernel.themes_metadata')[$bundleName]['path'] ?? null
        };
    }
}