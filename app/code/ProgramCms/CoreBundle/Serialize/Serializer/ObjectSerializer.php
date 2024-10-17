<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Serialize\Serializer;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ReflectionException;

/**
 * Class ObjectSerializer
 * @package ProgramCms\CoreBundle\Serialize\Serializer
 */
class ObjectSerializer
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * ObjectSerializer constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Array to Object Transformer
     * @param AbstractEntity $object
     * @param array $formData
     * @throws ReflectionException
     */
    public function arrayToObject(AbstractEntity $object, array $formData)
    {
        $refClass = new \ReflectionClass($object);

        // Process Doctrine Proxy Entitie
        if($refClass->implementsInterface(\Doctrine\ORM\Proxy\Proxy::class)) {
            $class = get_parent_class($object);
            $refClass = new \ReflectionClass($class);
        }

        foreach($formData as $property => $dataValue) {
            if($refClass->hasProperty($property)) {
                $propertyObject = $refClass->getProperty($property);
                $name = $propertyObject->name;
                $type = $propertyObject->getType();
                if ($type instanceof \ReflectionNamedType && !($type->isBuiltin()) && ($type->getName() != Collection::class)) {
                    $repository = $this->entityManager->getRepository($type->getName());
                    if ($repository) {
                        $obj = $repository->getById($formData[$name]);
                        if ($obj) {
                            $object->setDataUsingMethod($property, $obj);
                        }
                    }
                }else{
                    $object->setDataUsingMethod($property, $dataValue);
                }
            }else {
                $object->setDataUsingMethod($property, $dataValue);
            }
        }
    }
}