<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\UnitOfWork;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\EavBundle\Entity\EavAttribute;
use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue;
use ProgramCms\EavBundle\Model\Entity\Attribute\Backend\AbstractBackend;
use ProgramCms\EavBundle\Model\Entity\Entity;

/**
 * Class EavEntityPersistListener
 * @package ProgramCms\EavBundle\EventListener
 */
class EavEntityPersistSubscriber implements EventSubscriber
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * EavEntityPersistListener constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args): void
    {
        /** @var UnitOfWork $unitOfWork */
        $entityManager = $args->getObjectManager();
        $unitOfWork = $entityManager->getUnitOfWork();
        // Get the entities scheduled for insertion, update, and deletion
        $entitiesToSave = array_merge($unitOfWork->getScheduledEntityUpdates(), $unitOfWork->getScheduledEntityInsertions());
        foreach($entitiesToSave as $entity) {
            if($entity instanceof Entity) {
                try {
                    $data = $entity->getData();
                    foreach ($data as $key => $value) {
                        // If attribute value is empty ignore save
                        if(!isset($value)) {
                            continue;
                        }
                        if ($attribute = $this->findAttribute($key, $entity)) {
                            $backendType = $attribute->getBackendType();

                            $backendModelClass = $attribute->getBackendModel();
                            if($backendModelClass) {
                                /** @var AbstractBackend $backendModel */
                                $backendModel = $this->objectManager->create($backendModelClass);
                                $backendModel->beforeSave($attribute->getAttributeCode(), $entity);
                            }
                            /** @var AbstractRepository $repository */
                            $repository = $args->getObjectManager()->getRepository($backendType);
                            /** @var AttributeValue $attributeValue */
                            $attributeValue = $repository->findOneBy([
                                'entity_id' => $entity->getEntityId(),
                                'attribute_id' => $attribute->getAttributeId()
                            ]);
                            if (!$attributeValue) {
                                $attributeValue = $this->objectManager->create($backendType);
                                $attributeValue->setEntityId($entity->getEntityId());
                                $attributeValue->setAttributeId($attribute);
                            }

                            if ($entity->getData($key) != $attributeValue->getValue()) {
                                $attributeValue->setValue($entity->getData($key));
                                // Save EAV value
                                $entityManager->persist($attributeValue);
                                $unitOfWork->computeChangeSet($entityManager->getClassMetadata(get_class($attributeValue)), $attributeValue);
                            }
                        }
                    }
                }catch(\Exception $exception) {
                    $args->getObjectManager()->clear();
                    dd($exception);
                }
            }
        }
    }

    /**
     * @param string $key
     * @param $entity
     * @return false|EavAttribute
     */
    private function findAttribute(string $key, $entity): bool|EavAttribute
    {
        $attributes = $entity->getEntityType()->getAttributes();
        /** @var EavAttribute $attribute */
        foreach($attributes as $attribute) {
            if($attribute->getAttributeCode() == $key) {
                return $attribute;
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush
        ];
    }
}