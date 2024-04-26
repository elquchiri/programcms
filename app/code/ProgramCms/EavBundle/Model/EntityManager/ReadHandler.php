<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\EntityManager;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use ProgramCms\EavBundle\Model\Entity\Entity;
use ProgramCms\EavBundle\Model\Config;

use function get_class;

/**
 * Class ReadHandler
 * @package ProgramCms\EavBundle\Model\EntityManager
 */
class ReadHandler implements AttributeInterface
{
    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * ReadHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param Config $config
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        Config $config
    )
    {
        $this->config = $config;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Entity $entity
     * @throws Exception
     */
    public function execute(Entity $entity)
    {
        $metadata = $this->entityManager->getClassMetadata(get_class($entity));
        $queryBuilder = $this->entityManager->getConnection()->createQueryBuilder();

        $attributeTables = [];
        $attributesMap = [];
        $selects = [];

        foreach ($this->getEntityAttributes($entity) as $attribute) {
            $attributeTables[$attribute->getBackendType()][] = $attribute->getData('attribute_id');
            $attributesMap[$attribute->getData('attribute_id')] = $attribute->getData('attribute_code');
        }

        if (count($attributeTables)) {
            foreach ($attributeTables as $attributeTable => $attributeIds) {
                $select = $queryBuilder
                    ->select(['t.value AS value', 't.attribute_id AS attribute_id'])
                    ->from($attributeTable, 't')
                    ->where(
                        $queryBuilder->expr()->andX(
                            $queryBuilder->expr()->eq('t.' . $metadata->getSingleIdentifierFieldName(), $entity->getData($metadata->getSingleIdentifierFieldName())),
                            $queryBuilder->expr()->in('t.attribute_id', $attributeIds)
                        )
                    );

                // Append select
                $selects[] = $select;
            }

            $unionQuery = $this->generateUnionQuery($selects);
            $finalQuery = $this->entityManager->getConnection()->executeQuery($unionQuery);
            $attributes = $finalQuery->fetchAllAssociative();
            foreach ($attributes as $attributeValue) {
                if (isset($attributesMap[$attributeValue['attribute_id']])) {
                    $entity->setData(
                        $attributesMap[$attributeValue['attribute_id']],
                        $attributeValue['value']
                    );
                } else {
                    // Attempt to load value of nonexistent EAV attribute
                    // TODO: Log error messages
                }
            }
        }
    }

    /**
     * @param array $subQueries
     * @return string
     */
    private function generateUnionQuery(array $subQueries): string
    {
        // Wrap each sub-query in parentheses and concatenate with UNION
        return implode(' UNION ', array_map(fn($subQuery) => "($subQuery)", $subQueries));
    }

    /**
     * @param Entity $entity
     * @return array
     * @throws Exception
     */
    private function getEntityAttributes(Entity $entity): array
    {
        $metadata = $this->entityManager->getClassMetadata(get_class($entity));
        $eavEntityType = $metadata->getTableName();
        return $eavEntityType === null  ? [] : $this->config->getEntityAttributes($eavEntityType, $entity);
    }
}