<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model;

use Exception;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\EavBundle\Entity\EavAttribute;
use ProgramCms\EavBundle\Model\Entity\Entity;
use ProgramCms\EavBundle\Model\EntityManager\Entity\Type\Collection as EntityTypeCollection;

/**
 * Class Config
 * @package ProgramCms\EavBundle\Model
 */
class Config
{

    /**
     * @var array
     */
    protected array $attributes;

    /**
     * @var array
     */
    protected array $attributeCache;

    /**
     * @var array
     */
    protected array $_references;

    /**
     * @var array
     */
    protected array $_entityTypeData;

    /**
     * @var array
     */
    protected array $_attributeData;

    /**
     * @var EntityManager\Entity\Type\Collection
     */
    protected EntityManager\Entity\Type\Collection $entityTypeCollection;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * Config constructor.
     * @param ObjectManager $objectManager
     * @param EntityManager\Entity\Type\Collection $entityTypeCollection
     */
    public function __construct(
        ObjectManager $objectManager,
        EntityTypeCollection $entityTypeCollection,
    )
    {
        $this->_attributeData = [];
        $this->attributeCache = [];
        $this->entityTypeCollection = $entityTypeCollection;
        $this->objectManager = $objectManager;
    }

    /**
     * Get attributes by entity type code
     * @param $entityTypeCode
     * @return array|mixed
     */
    private function loadAttributes($entityTypeCode)
    {
        return $this->attributes[$entityTypeCode] ?? [];
    }

    /**
     * @param EavAttribute $attribute
     * @param $entityTypeCode
     * @param $attributeCode
     */
    private function saveAttribute(EavAttribute $attribute, $entityTypeCode, $attributeCode)
    {
        $this->attributes[$entityTypeCode][$attributeCode] = $attribute;
    }

    /**
     * @param $id
     * @param $code
     * @return $this
     */
    protected function _addEntityTypeReference($id, $code)
    {
        $this->_references['entity'][$id] = $code;
        return $this;
    }

    /**
     * @param $id
     * @param $code
     * @param $entityTypeCode
     * @return $this
     */
    protected function _addAttributeReference($id, $code, $entityTypeCode)
    {
        $this->_references['attribute'][$entityTypeCode][$id] = $code;
        return $this;
    }

    /**
     * Initialize all entity types data
     * @return $this
     */
    protected function _initEntityTypes(): static
    {
        $entityTypesData = $this->entityTypeCollection->getData();
        foreach ($entityTypesData as $typeData) {
            $typeCode = $typeData->getData('entity_type_code');
            $typeId = $typeData->getData('entity_type_id');

            $this->_addEntityTypeReference($typeId, $typeCode);
            $this->_entityTypeData[$typeCode] = $typeData;
        }
        return $this;
    }

    /**
     * @param string $code
     * @return mixed|null
     */
    public function getEntityType(string $code)
    {
        $this->_initEntityTypes();

        return $this->_entityTypeData[$code] ?? null;
    }

    /**
     * @param string $entityType
     * @return $this
     * @throws Exception
     */
    protected function _initAttributes(string $entityType)
    {
        $entityType = $this->getEntityType($entityType);
        $entityTypeCode = $entityType->getEntityTypeCode();

        if (is_array($this->_attributeData) && isset($this->_attributeData[$entityTypeCode])) {
            return $this;
        }

        $attributes = $this->objectManager->create($entityType->getEntityAttributeCollection());
        $attributes = $attributes->setEntityTypeFilter($entityType)->getData();

        foreach ($attributes as $attribute) {
            // If no attribute_model defined inside attribute, get the entity type one
            if (isset($attribute['attribute_model']) && empty($attribute['attribute_model'])) {
                $attribute['attribute_model'] = $entityType->getAttributeModel();
            }
            $attributeObject = $this->_createAttribute($entityTypeCode, $attribute);
            $this->saveAttribute($attributeObject, $entityTypeCode, $attributeObject->getAttributeCode());
            $this->_attributeData[$entityTypeCode][$attribute['attribute_code']] = $attributeObject->getData();
        }

        return $this;
    }

    /**
     * @param string $entityTypeCode
     * @param $attributeData
     * @return mixed
     */
    protected function _createAttribute(string $entityTypeCode, $attributeData)
    {
        $entityType = $this->getEntityType($entityTypeCode);
        $entityTypeCode = $entityType->getEntityTypeCode();

        $code = $attributeData['attribute_code'];
        $attributes = $this->loadAttributes($entityTypeCode);
        $attribute = $attributes[$code] ?? null;

        if($attribute) {
            return $attribute;
        }

        if (!empty($attributeData['attribute_model'])) {
            $model = $attributeData['attribute_model'];
        } else {
            $model = $entityType->getAttributeModel();
        }

        $attribute = $this->createAttribute($model)->setData($attributeData);
        $attribute->setData('entity_type_id', $attribute->getEntityTypeId());
        $this->_addAttributeReference(
            $attributeData['attribute_id'],
            $code,
            $entityTypeCode
        );
        $this->saveAttribute($attribute, $entityTypeCode, $code);

        return $attribute;
    }

    /**
     * @param $model
     * @return mixed
     */
    public function createAttribute($model)
    {
        if (!isset($this->attributeCache[$model])) {
            $this->attributeCache[$model] = $this->objectManager->create($model);
        }
        return clone $this->attributeCache[$model];
    }

    /**
     * @param string $entityType
     * @param Entity|null $entity
     * @return array
     * @throws Exception
     */
    public function getEntityAttributes(string $entityType, Entity $entity = null): array
    {
        $attributes = [];
        $this->_initAttributes($entityType);
        $attributesData = $this->_attributeData[$entityType];
        foreach ($attributesData as $attributeData) {
            $attributes[$attributeData['attribute_code']] = $this->_createAttribute($entityType, $attributeData);
        }

        return $attributes;
    }
}