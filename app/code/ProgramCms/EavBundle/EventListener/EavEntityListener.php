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
use Doctrine\ORM\Proxy\Proxy;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\EavBundle\Entity\EavAttribute;
use ProgramCms\EavBundle\Entity\EavEntityType;
use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue;
use ProgramCms\EavBundle\Model\Entity\Attribute\Frontend\AbstractFrontend;
use ProgramCms\EavBundle\Model\Entity\Entity;
use ProgramCms\WebsiteBundle\App\ScopedAttributeValue;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;
use Exception;

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
     * @var WebsiteManagerInterface
     */
    protected WebsiteManagerInterface $websiteManager;

    /**
     * EavEntityListener constructor.
     * @param EntityManagerInterface $entityManager
     * @param ObjectManager $objectManager
     * @param WebsiteManagerInterface $websiteManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ObjectManager $objectManager,
        WebsiteManagerInterface $websiteManager
    )
    {
        $this->entityManager = $entityManager;
        $this->objectManager = $objectManager;
        $this->websiteManager = $websiteManager;
    }

    /**
     * @param PostLoadEventArgs $args
     * @throws Exception
     */
    public function postLoad(PostLoadEventArgs $args): void
    {
        $entity = $args->getObject();
        if($entity instanceof Entity) {
            $entityClass = $entity instanceof Proxy ? get_parent_class($entity) : get_class($entity);
            /** @var EavEntityType $eavEntityType */
            $eavEntityType = $this->entityManager
                ->getRepository(EavEntityType::class)
                ->findOneBy(['entity_type_code' => $entityClass]);

            if ($eavEntityType) {
                $entityType = $entity->setEntityType($eavEntityType);
                /** @var EavAttribute $attribute */
                foreach($entityType->getEntityType()->getAttributes() as $attribute) {
                    $backendType = $attribute->getBackendType();
                    $repository = $args->getObjectManager()->getRepository($backendType);

                    $reflection = new \ReflectionClass($backendType);
                    if($reflection->isSubclassOf(ScopedAttributeValue::class)) {
                        $websiteView = $this->websiteManager->getWebsiteView();
                        /** @var AttributeValue $value */
                        // Get value from current websiteView else get the null websiteView value
                        // TODO: Improve to fallback mechanism
                        $value = $repository->findOneBy([
                            'entity_id' => $entity->getEntityId(),
                            'attribute_id' => $attribute->getAttributeId(),
                            'websiteView' => $websiteView
                        ]);
                        if(!$value) {
                            $value = $repository->findOneBy([
                                'entity_id' => $entity->getEntityId(),
                                'attribute_id' => $attribute->getAttributeId(),
                            ]);
                        }
                    }else{
                        /** @var AttributeValue $value */
                        $value = $repository->findOneBy([
                            'entity_id' => $entity->getEntityId(),
                            'attribute_id' => $attribute->getAttributeId()
                        ]);
                    }
                    $attributeValue = $value ? $value->getValue() : '';
                    //$entity->setData($attribute->getAttributeCode(), $attributeValue);
                    if($attribute->getFrontendModel()) {
                        /** @var AbstractFrontend $frontendModel */
                        $frontendModel = $this->objectManager->create($attribute->getFrontendModel());
                        $attributeValue = $frontendModel->getValue($attribute->getAttributeCode(), $attributeValue, $entity);
                    }
                    $entity->setData($attribute->getAttributeCode(), $attributeValue);
                }
            }
        }
    }
}