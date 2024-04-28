<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Setup;

use Doctrine\ORM\EntityManagerInterface;
use ProgramCms\CoreBundle\Model\DataObject;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\EavBundle\Entity\EavAttribute;
use ProgramCms\EavBundle\Entity\EavAttributeSet;
use ProgramCms\EavBundle\Entity\EavEntityType;
use ProgramCms\EavBundle\Repository\EavAttributeRepository;
use ProgramCms\EavBundle\Repository\EavAttributeSetRepository;
use ProgramCms\EavBundle\Repository\EavEntityTypeRepository;

/**
 * Class EavSetup
 * @package ProgramCms\EavBundle\Setup
 */
class EavSetup implements EavSetupInterface
{
    /**
     * @var EavAttributeRepository
     */
    protected EavAttributeRepository $eavAttributeRepository;

    /**
     * @var EavEntityTypeRepository
     */
    protected EavEntityTypeRepository $entityTypeRepository;

    /**
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * @var EavAttributeSetRepository
     */
    protected EavAttributeSetRepository $eavAttributeSetRepository;

    /**
     * EavSetup constructor.
     * @param EavAttributeRepository $eavAttributeRepository
     * @param EavEntityTypeRepository $entityTypeRepository
     * @param EavAttributeSetRepository $eavAttributeSetRepository
     * @param ObjectSerializer $objectSerializer
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EavAttributeRepository $eavAttributeRepository,
        EavEntityTypeRepository $entityTypeRepository,
        EavAttributeSetRepository $eavAttributeSetRepository,
        ObjectSerializer $objectSerializer,
        EntityManagerInterface $entityManager
    )
    {
        $this->eavAttributeRepository = $eavAttributeRepository;
        $this->entityTypeRepository = $entityTypeRepository;
        $this->objectSerializer = $objectSerializer;
        $this->entityManager = $entityManager;
        $this->eavAttributeSetRepository = $eavAttributeSetRepository;
    }

    /**
     * @param string $entityType
     * @param string $code
     * @param array $attributeData
     * @throws \Exception
     */
    public function addAttribute(string $entityType, string $code, array $attributeData)
    {
        /** @var EavEntityType $entityTypeEntity */
        $entityTypeEntity = $this->entityTypeRepository->getByTypeCode($entityType);
        if(!$entityTypeEntity) {
            throw new \Exception(
                sprintf("Entity type %s not found", $entityType)
            );
        }
        $attribute = new EavAttribute();
        $this->objectSerializer->arrayToObject($attribute, $attributeData);
        $attribute->setAttributeCode($code);
        $attribute->setEntityType($entityTypeEntity);
        $this->eavAttributeRepository->save($attribute);

        $entityAdditionalEavClass = $entityTypeEntity->getAdditionalAttributeTable();
        $entityAdditionalEav = new $entityAdditionalEavClass();
        $this->objectSerializer->arrayToObject($entityAdditionalEav, $attributeData);
        $entityAdditionalEav->setAttributeId($attribute);
        $repository = $this->entityManager->getRepository($entityAdditionalEavClass);
        $repository->save($entityAdditionalEav);
    }

    /**
     * @param string $entityTypeCode
     * @param array $entityData
     * @return void
     */
    public function addEntityType(string $entityTypeCode, array $entityData)
    {
        $entityType = new EavEntityType();
        $entityTypeData = $this->prepareEntityTypeData($entityData);
        $entityType
            ->setEntityTypeCode($entityTypeCode)
            ->setAdditionalAttributeTable($entityTypeData->getAdditionalAttributeEntity());
        $this->entityTypeRepository->save($entityType);
    }

    /**
     * @param array $entityData
     * @return DataObject
     */
    private function prepareEntityTypeData(array $entityData): DataObject
    {
        $dataObject = new DataObject();
        $data = [
            'additional_attribute_entity' => $entityData['additional_attribute_entity'] ?? ''
        ];
        $dataObject->setData(array_merge($data, $entityData));
        return $dataObject;
    }

    /**
     * @param string $entityTypeCode
     * @param array $attributeSetData
     */
    public function addAttributeSet(string $entityTypeCode, array $attributeSetData)
    {
        /** @var EavEntityType $entityType */
        $entityType = $this->entityTypeRepository->getByTypeCode($entityTypeCode);
        $attributeSetDataObject = $this->prepareAttributeSetData($attributeSetData);
        $attributeSet = new EavAttributeSet();
        $attributeSet
            ->setAttributeSetName($attributeSetDataObject->getAttributeSetName())
            ->setEntityType($entityType);
        // Save Attribute Set
        $this->eavAttributeSetRepository->save($attributeSet);
    }

    /**
     * @param array $attributeSetData
     * @return DataObject
     */
    private function prepareAttributeSetData(array $attributeSetData): DataObject
    {
        $dataObject = new DataObject();
        $data = [
            'attribute_set_name' => $entityData['attribute_set_name'] ?? ''
        ];
        $dataObject->setData(array_merge($data, $attributeSetData));
        return $dataObject;
    }
}