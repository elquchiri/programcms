<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model\Utils;

use Exception;
use ProgramCms\CoreBundle\Entity\Bundle;
use ProgramCms\CoreBundle\ProgramCmsCoreBundle;
use ProgramCms\CoreBundle\Repository\BundleRepository;
use Psr\Cache\InvalidArgumentException;
use ReflectionException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Class BundleManager
 * @package ProgramCms\CoreBundle\Model\Utils
 */
class BundleManager implements BundleManagerInterface
{
    const BUNDLE = 'bundle';

    const THEME = 'theme';

    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @var BundleRepository
     */
    protected BundleRepository $bundleRepository;
    protected CacheInterface $cache;

    /**
     * BundleManager constructor.
     * @param ContainerInterface $container
     * @param BundleRepository $bundleRepository
     */
    public function __construct(
        ContainerInterface $container,
        BundleRepository $bundleRepository,
        CacheInterface $cache
    )
    {
        $this->container = $container;
        $this->bundleRepository = $bundleRepository;
        $this->cache = $cache;
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
     * @throws ReflectionException|InvalidArgumentException
     */
    public function getAllBundles(): array
    {
        return $this->cache->get('bundles', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            $bundles = [];
            foreach ($this->getContainerParameter('kernel.bundles') as $bundleName => $bundleClass) {
                $reflectedBundle = new \ReflectionClass($bundleClass);
                if ($reflectedBundle->isSubclassOf(ProgramCmsCoreBundle::class)) {
                    $bundleDirectory = dirname($reflectedBundle->getFileName());
                    $bundleShortName = $reflectedBundle->getShortName();

                    $bundleObject = $this->bundleRepository->getByShortName($bundleShortName);
                    if(!$bundleObject) {
                        $bundleObject = new Bundle();
                        $bundleObject
                            ->setBundleName($bundleShortName)
                            ->setBundlePath($bundleDirectory)
                            ->setStatus(true)
                            ->updateTimestamps();
                    }

                    $this->bundleRepository->save($bundleObject);

                    // Add Only active bundles
                    if($bundleObject->getStatus() === true) {
                        $bundles[$bundleName] = [
                            'name' => $bundleShortName,
                            'path' => $bundleDirectory,
                            'class' => $bundleClass
                        ];
                    }
                }
            }

            return $bundles;
        });
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