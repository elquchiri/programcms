<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Setup;

use Doctrine\ORM\EntityManagerInterface;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\EavBundle\Entity\EavAttribute;
use ProgramCms\EavBundle\Entity\EavEntityType;
use ProgramCms\EavBundle\Repository\EavAttributeRepository;
use ProgramCms\EavBundle\Repository\EavEntityTypeRepository;

/**
 * Class EavSetup
 * @package ProgramCms\EavBundle\Setup
 */
class EavSetup
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
     * EavSetup constructor.
     * @param EavAttributeRepository $eavAttributeRepository
     * @param EavEntityTypeRepository $entityTypeRepository
     * @param ObjectSerializer $objectSerializer
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EavAttributeRepository $eavAttributeRepository,
        EavEntityTypeRepository $entityTypeRepository,
        ObjectSerializer $objectSerializer,
        EntityManagerInterface $entityManager
    )
    {
        $this->eavAttributeRepository = $eavAttributeRepository;
        $this->entityTypeRepository = $entityTypeRepository;
        $this->objectSerializer = $objectSerializer;
        $this->entityManager = $entityManager;
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
}