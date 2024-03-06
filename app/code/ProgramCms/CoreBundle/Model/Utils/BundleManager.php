<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model\Utils;

use ReflectionException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ProgramCms\CoreBundle\Helper\BundleManager as BundleManagerHelper;

/**
 * Class BundleManager
 * @package ProgramCms\CoreBundle\Model\Utils
 */
class BundleManager
{
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
     * @return array|bool|float|int|string|\UnitEnum|null
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
            if ($reflectedBundle->hasMethod(BundleManagerHelper::PROGRAMCMS_METHOD_DEFINER) && $reflectedBundle->getMethod(BundleManagerHelper::PROGRAMCMS_METHOD_DEFINER)) {
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
     * @throws \Exception
     */
    public function getBundleByName($bundleName)
    {
        $bundles = $this->getAllBundles();

        if(isset($bundles[$bundleName])) {
            return $bundles[$bundleName];
        }

        throw new \Exception(sprintf("Invalid Bundle %s", $bundleName));
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getNames(): array
    {
        return array_keys($this->getAllBundles());
    }
}