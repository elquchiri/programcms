<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Exception;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\EavBundle\Entity\EavAttribute;
use ProgramCms\EavBundle\Entity\EavEntityType;
use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue;
use ProgramCms\EavBundle\Model\Entity\Attribute\Frontend\AbstractFrontend;
use ProgramCms\EavBundle\Model\Entity\Entity;

/**
 * Class EavEntityListener
 * @package ProgramCms\EavBundle\EventListener
 */
class EavEntityListener
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * EavEntityListener constructor.
     * @param EntityManagerInterface $entityManager
     * @param ObjectManager $objectManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ObjectManager $objectManager
    )
    {
        $this->entityManager = $entityManager;
        $this->objectManager = $objectManager;
    }

    /**
     * @param PostLoadEventArgs $args
     * @throws Exception
     */
    public function postLoad(PostLoadEventArgs $args): void
    {
        $entity = $args->getObject();
        if($entity instanceof Entity) {
            /** @var EavEntityType $eavEntityType */
            $eavEntityType = $this->entityManager
                ->getRepository(EavEntityType::class)
                ->findOneBy(['entity_type_code' => get_class($entity)]);

            if ($eavEntityType) {
                $entityType = $entity->setEntityType($eavEntityType);
                $entityType->getEntityType()->setEntity($entity);
                /** @var EavAttribute $attribute */
                foreach($entityType->getEntityType()->getAttributes() as $attribute) {
                    $backendType = $attribute->getBackendType();
                    $respository = $args->getObjectManager()->getRepository($backendType);
                    /** @var AttributeValue $value */
                    $value = $respository->findOneBy([
                        'entity_id' => $entity->getEntityId(),
                        'attribute_id' => $attribute->getAttributeId()
                    ]);
                    $attributeValue = $value ? $value->getValue() : '';
                    $entity->setData($attribute->getAttributeCode(), $attributeValue);
                    if($attribute->getFrontendModel()) {
                        /** @var AbstractFrontend $frontendModel */
                        $frontendModel = $this->objectManager->create($attribute->getFrontendModel());
                        $attributeValue = $frontendModel->getValue($attribute->getAttributeCode(), $entity);
                    }
                    $entity->setData($attribute->getAttributeCode(), $attributeValue);
                }
            }
        }
    }
}