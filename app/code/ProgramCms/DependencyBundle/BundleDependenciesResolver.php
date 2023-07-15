<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DependencyBundle;

use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ProgramCms\DependencyBundle\Exception\BundleDependencyException;

/**
 * Trait BundleDependenciesResolver
 * @package ProgramCms\BundleDependencyBundle
 */
trait BundleDependenciesResolver
{
    /**
     * @param array $bundles
     * @return array
     * @throws ReflectionException
     */
    protected function _getBundleInstances(array $bundles): array
    {
        $builtBundles = [];
        $bundleStack = $this->_prepareBundleDependencies($bundles);
        foreach ($bundleStack as $bundle) {
            $builtBundles[] = $this->_getBundleDefinitionInstance($bundle);
        }

        return $builtBundles;
    }

    /**
     * @param array $bundles
     * @return array
     * @throws ReflectionException
     */
    protected function _prepareBundleDependencies(array $bundles): array
    {
        $bundleStack = [];
        $visitedBundles = [];
        $this->_resolveBundleDependencies($bundleStack, $visitedBundles, $bundles);

        return $bundleStack;
    }

    /**
     * @param array $bundleStack
     * @param array $visitedBundles
     * @param array $bundles
     * @throws ReflectionException
     */
    private function _resolveBundleDependencies(
        array &$bundleStack,
        array &$visitedBundles,
        array $bundles
    )
    {
        $bundles = array_reverse($bundles);

        foreach ($bundles as $bundle) {
            // Each visited node is prioritized and placed at the beginning.
            $this->_prioritizeBundle($bundleStack, $bundle);
        }

        foreach ($bundles as $bundle) {
            $bundleNamespace = $this->_getBundleDefinitionNamespace($bundle);
            // Continue if this bundle was already visited
            if (isset($visitedBundles[$bundleNamespace])) {
                continue;
            }

            $visitedBundles[$bundleNamespace] = true;
            $bundleNamespaceObj = new ReflectionClass($bundleNamespace);
            if ($bundleNamespaceObj->implementsInterface(DependentBundleInterface::class)) {
                $bundleDependencies = $bundleNamespace::getDependencies();
                $this->_resolveBundleDependencies($bundleStack, $visitedBundles, $bundleDependencies);
            }
        }
    }

    /**
     * @param array $bundleStack
     * @param $elementToPrioritize
     */
    private function _prioritizeBundle(array &$bundleStack, $elementToPrioritize)
    {
        $elementNamespace = $this->_getBundleDefinitionNamespace($elementToPrioritize);
        foreach ($bundleStack as $bundlePosition => $bundle) {
            $bundleNamespace = $this->_getBundleDefinitionNamespace($bundle);

            if ($elementNamespace == $bundleNamespace) {
                unset($bundleStack[$bundlePosition]);
            }
        }
        array_unshift($bundleStack, $elementToPrioritize);
    }

    /**
     * @param $bundle
     * @return string
     */
    private function _getBundleDefinitionNamespace($bundle): string
    {
        return ltrim(is_object($bundle)
            ? get_class($bundle)
            : $bundle, ' \\');
    }

    /**
     * @param $bundle
     * @return BundleInterface
     */
    private function _getBundleDefinitionInstance($bundle): BundleInterface
    {
        if (!is_object($bundle)) {
            $bundle = new $bundle($this);
        }

        if (!$bundle instanceof BundleInterface) {
            throw new BundleDependencyException(get_class($bundle));
        }

        return $bundle;
    }
}