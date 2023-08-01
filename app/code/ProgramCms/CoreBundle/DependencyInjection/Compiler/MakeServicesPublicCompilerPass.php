<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\DependencyInjection\Compiler;

use ReflectionException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class MakeServicesPublicCompilerPass
 * @package ProgramCms\CoreBundle\DependencyInjection\Compiler
 */
class MakeServicesPublicCompilerPass implements \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     * @throws ReflectionException
     */
    public function process(ContainerBuilder $container)
    {
        $definitions = $container->getDefinitions();
        foreach ($definitions as $definition) {
            if(class_exists($definition->getClass())) {
                if ($bundle = $this->_getBundleForService($container, $definition->getClass())) {
                    if (is_a($bundle, \ProgramCms\CoreBundle\ProgramCmsCoreBundle::class)) {
                        $reflection = new \ReflectionClass($definition->getClass());
                        if(!$reflection->isAbstract()) {
                            // Make each service public.
                            $definition
                                ->setAutoconfigured(true)
                                ->setAutowired(true)
                                ->setPublic(true);
                            // Add controllers tag
                            if ($reflection->isSubclassOf(\ProgramCms\CoreBundle\Controller\AbstractController::class)) {
                                $definition
                                    ->addTag('controller.service_arguments')
                                    ->addTag('container.service_subscriber');
                            }else if($reflection->isSubclassOf(\Symfony\Component\Console\Command\Command::class)) {
                                $definition
                                    ->addTag('console.command');
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Get the BundleInterface instance associated with a service class.
     *
     * @param ContainerBuilder $container
     * @param string $serviceClassName
     */
    private function _getBundleForService(ContainerBuilder $container, string $serviceClassName)
    {
        // Get all registered bundles in the application.
        $bundles = $container->getParameter('kernel.bundles');

        foreach ($bundles as $bundleName => $bundleClass) {
            // Get the bundle instance.
            $reflectionBundle = new \ReflectionClass($bundleClass);
            $bundle = $reflectionBundle->newInstance();

            // Check if the service class belongs to this bundle.
            if (str_starts_with($serviceClassName, $bundle->getNamespace())) {
                return $bundle;
            }
        }

        return null; // Service is not associated with any bundle.
    }
}