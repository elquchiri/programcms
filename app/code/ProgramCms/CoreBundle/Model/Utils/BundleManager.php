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
 * Class BundleManager
 * @package ProgramCms\CoreBundle\Model\Utils
 */
class BundleManager
{
    protected ContainerInterface $container;

    public function __construct(
        ContainerInterface $container
    )
    {
        $this->container = $container;
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function getAllEfBundles(): array
    {
        $efBundles = [];
        foreach ($this->container->getParameter('kernel.bundles') as $bundleName => $bundleClass) {
            $reflectedBundle = new \ReflectionClass($bundleClass);
            if ($reflectedBundle->hasMethod('isProgramCmsBundle') && $reflectedBundle->getMethod('isProgramCmsBundle')) {
                $bundleDirectory = dirname($reflectedBundle->getFileName());
                $efBundles[$bundleName] = [
                    'name' => $reflectedBundle->getShortName(),
                    'path' => $bundleDirectory
                ];
            }
        }

        return $efBundles;
    }

    /**
     * @throws \Exception
     */
    public function getBundleByName($bundleName)
    {
        $bundles = $this->getAllEfBundles();
        if(isset($bundles[$bundleName])) {
            return $bundles[$bundleName];
        }
        throw new \Exception(sprintf("Invalid Bundle %s", $bundleName));
    }

}