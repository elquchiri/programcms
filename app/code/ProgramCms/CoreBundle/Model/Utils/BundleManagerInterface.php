<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Interface BundleManagerInterface
 * @package ProgramCms\CoreBundle\Model\Utils
 */
interface BundleManagerInterface
{
    /**
     * @return array
     */
    public function getAllBundles(): array;

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface;

    /**
     * @param $parameter
     * @return mixed
     */
    public function getContainerParameter($parameter);

    /**
     * @param $bundleName
     * @return mixed
     */
    public function getBundleByName($bundleName);

    /**
     * @return array
     */
    public function getAllThemes(): array;

    /**
     * @param $themeName
     * @return mixed
     */
    public function getThemeByName($themeName);

    /**
     * @param string $bundleType
     * @param string $bundleName
     * @return string|null
     */
    public function getPath(string $bundleType, string $bundleName): ?string;
}