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
use ProgramCms\EavBundle\Entity\EavAttribute;
use ProgramCms\EavBundle\Helper\Entity as EntityHelper;

/**
 * Class EavAttributeListener
 * @package ProgramCms\EavBundle\EventListener
 */
class EavAttributeListener
{
    const EAV_ATTRIBUTE_VALUE_TABLE_PATTERN = '%s_%s';

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * @var EntityHelper
     */
    protected EntityHelper $entityHelper;

    /**
     * EavAttributeListener constructor.
     * @param EntityManagerInterface $entityManager
     * @param EntityHelper $entityHelper
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        EntityHelper $entityHelper
    )
    {
        $this->entityManager = $entityManager;
        $this->entityHelper = $entityHelper;
    }

    /**
     * @param PostLoadEventArgs $args
     * @throws Exception
     */
    public function postLoad(PostLoadEventArgs $args): void
    {
        $attribute = $args->getObject();
        if($attribute instanceof EavAttribute) {
            $entityType = $attribute->getEntityType();
            if($entityType) {
                $metadata = $this->entityManager->getClassMetadata($entityType->getEntityTypeCode());
                $tableName = sprintf(self::EAV_ATTRIBUTE_VALUE_TABLE_PATTERN, $metadata->getTableName(), $attribute->getBackendType());
                $entityValueClass = $this->entityHelper->getEntityClassNameFromTableName($tableName);
                $value = $this->entityManager
                    ->createQueryBuilder()
                    ->select('v')
                    ->from($entityValueClass, 'v')
                    ->andWhere('v.attribute_id = :attribute_id')
                    ->setParameter(':attribute_id', $attribute)
                    ->getQuery()
                    ->getResult();

                // Assign attribute value
                $attribute->setValue(reset($value));

                // Load additional attributes
                $this->loadAdditionalAttribute($attribute);
            }
        }
    }

    /**
     * @param EavAttribute $attribute
     */
    private function loadAdditionalAttribute(EavAttribute $attribute)
    {
        $entityType = $attribute->getEntityType();

        $additionalAttribute = $this->entityManager
            ->getRepository($entityType->getAdditionalAttributeTable())
            ->findOneBy(['attribute_id' => $attribute->getAttributeId()]);

        if ($additionalAttribute) {
            $attribute->setAdditionalAttribute($additionalAttribute);
        }
    }
}