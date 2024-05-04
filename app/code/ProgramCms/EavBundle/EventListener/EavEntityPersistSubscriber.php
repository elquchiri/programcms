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
use Doctrine\ORM\Proxy\Proxy;
use Doctrine\ORM\UnitOfWork;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\EavBundle\Entity\EavAttribute;
use ProgramCms\EavBundle\Entity\EavEntityType;
use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue;
use ProgramCms\EavBundle\Model\Entity\Attribute\Backend\AbstractBackend;
use ProgramCms\EavBundle\Model\Entity\Entity;
use ProgramCms\EavBundle\Repository\EavEntityTypeRepository;
use ProgramCms\WebsiteBundle\App\ScopedAttributeValue;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;

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
     * @var EavEntityTypeRepository
     */
    protected EavEntityTypeRepository $eavEntityTypeRepository;

    /**
     * @var WebsiteManagerInterface
     */
    protected WebsiteManagerInterface $websiteManager;

    /**
     * EavEntityPersistListener constructor.
     * @param ObjectManager $objectManager
     * @param EavEntityTypeRepository $eavEntityTypeRepository
     * @param WebsiteManagerInterface $websiteManager
     */
    public function __construct(
        ObjectManager $objectManager,
        EavEntityTypeRepository $eavEntityTypeRepository,
        WebsiteManagerInterface $websiteManager
    )
    {
        $this->objectManager = $objectManager;
        $this->eavEntityTypeRepository = $eavEntityTypeRepository;
        $this->websiteManager = $websiteManager;
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

                            $findBy = [
                                'entity_id' => $entity,
                                'attribute_id' => $attribute->getAttributeId()
                            ];
                            $isScopped = false;

                            $reflection = new \ReflectionClass($backendType);
                            if($reflection->isSubclassOf(ScopedAttributeValue::class)) {
                                $currentWebsiteView = $this->websiteManager->getWebsiteView();
                                $findBy['websiteView'] = $currentWebsiteView;
                                $isScopped = true;
                            }

                            /** @var AbstractRepository $repository */
                            $repository = $args->getObjectManager()->getRepository($backendType);
                            /** @var AttributeValue $attributeValue */
                            $attributeValue = $repository->findOneBy($findBy);
                            if (!$attributeValue) {
                                $attributeValue = $this->objectManager->create($backendType);
                                $attributeValue->setEntityId($entity);
                                $attributeValue->setAttributeId($attribute);
                                if($isScopped) {
                                    $attributeValue->setWebsiteView($currentWebsiteView);
                                }
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
     * @param Entity $entity
     * @return false|EavAttribute
     */
    private function findAttribute(string $key, Entity $entity): bool|EavAttribute
    {
        $entityClass = $entity instanceof Proxy ? get_parent_class($entity) : get_class($entity);
        /** @var EavEntityType $entityType */
        $entityType = $this->eavEntityTypeRepository->getByTypeCode($entityClass);
        $attributes = $entityType->getAttributes();
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