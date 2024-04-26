<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model;

use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ObjectManager
 * @package ProgramCms\CoreBundle\Model
 */
class ObjectManager implements ObjectManagerInterface
{
    /**
     * @var Utils\BundleManager
     */
    protected Utils\BundleManager $bundleManager;

    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * ObjectManager constructor.
     * @param Utils\BundleManager $bundleManager
     */
    public function __construct(
        BundleManager $bundleManager
    )
    {
        $this->bundleManager = $bundleManager;
        $this->container = $this->bundleManager->getContainer();
    }

    /**
     * Clones / Create a service and returns a new instance of the object
     * @param string $serviceId
     * @param array $arguments
     * @return object|null
     * @throws ReflectionException
     */
    public function create(string $serviceId, array $arguments = []): ?object
    {
        if($this->container->has($serviceId) && empty($arguments)) {
            return clone $this->container->get($serviceId);
        }
        // Create a new object if arguments are required
        $reflection = new ReflectionClass($serviceId);

        if(!$reflection->isInstantiable()) {
            $reflection = new \ReflectionObject(
                $this->container->get($serviceId)
            );
        }

        $parameters = $reflection->getConstructor()->getParameters();
        $args = [];
        foreach($parameters as $parameter) {
            $parameterType = $parameter->getType();
            // If argument exists in $arguments, initialize it, even if it is optional
            if(in_array($parameter->getName(), array_keys($arguments))) {
                $args[] = $arguments[$parameter->getName()];
                continue;
            }
            // Skip if argument optional
            if($parameter->isOptional()) {
                break;
            }
            // If argument is an object, use container to get it.
            if($parameter->hasType() && ($parameterType instanceof \ReflectionNamedType) && !$parameterType->isBuiltin()) {
                $args[] = $this->container->get($parameter->getType());
            }
        }

        return $reflection->newInstanceArgs($args);
    }
}