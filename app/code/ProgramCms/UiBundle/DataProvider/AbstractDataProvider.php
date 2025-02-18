<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\DataProvider;

use Exception;
use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;
use ProgramCms\EavBundle\Entity\EavAttribute;
use ProgramCms\EavBundle\Entity\EavEntityType;

/**
 * Class AbstractDataProvider
 * @package ProgramCms\UiBundle\DataProvider
 */
abstract class AbstractDataProvider implements DataProviderInterface
{
    /**
     * Data Provider Primary Identifier name
     * @var string
     */
    protected string $primaryFieldName = '';

    /**
     * @var string
     */
    protected string $foreignFieldName = '';

    /**
     * Data Provider Request Parameter Identifier name
     * @var string
     */
    protected string $requestFieldName = '';

    /**
     * Provider configuration data
     * @var array
     */
    protected array $data = [];

    /**
     * @var AbstractCollection
     */
    protected AbstractCollection $collection;

    /**
     * @var array
     */
    protected array $filterStrategies = [];

    /**
     * Used to avoid
     * @var array
     */
    private array $joinAliases = [];

    /**
     * Get primary field name
     * @return string
     */
    public function getPrimaryFieldName(): string
    {
        return $this->primaryFieldName;
    }

    /**
     * Get field name in request
     * @return string
     */
    public function getRequestFieldName(): string
    {
        return $this->requestFieldName;
    }

    /**
     * @return AbstractCollection
     */
    public function getCollection(): AbstractCollection
    {
        return $this->collection;
    }

    /**
     * Get Data
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->getCollection()->getData();
    }

    /**
     * @param string $primaryFieldName
     * @return $this
     */
    public function setPrimaryFieldName(string $primaryFieldName)
    {
        $this->primaryFieldName = $primaryFieldName;
        return $this;
    }

    /**
     * @return string
     */
    public function getForeignFieldName(): string
    {
        return $this->foreignFieldName;
    }

    /**
     * @param string $foreignFieldName
     * @return $this
     */
    public function setForeignFieldName(string $foreignFieldName): static
    {
        $this->primaryFieldName = $foreignFieldName;
        return $this;
    }

    /**
     * @param string $requestFieldName
     * @return $this
     */
    public function setRequestFieldName(string $requestFieldName)
    {
        $this->requestFieldName = $requestFieldName;
        return $this;
    }

    /**
     * @param string $field
     */
    public function addField(string $field)
    {
        $this->getCollection()->addFieldToSelect($field);
    }

    /**
     * @param string $field
     * @param $value
     */
    public function addFilter(string $field, $value)
    {
        $this->getCollection()
            ->addFieldToFilter($field, $value);
    }

    /**
     * @return array
     */
    public function getFilterStrategies(): array
    {
        return $this->filterStrategies;
    }

    /**
     * @param array $filters
     * @throws Exception
     */
    public function searchByFilters(array $filters)
    {
        $entityManager = $this->getCollection()->getEntityManager();
        $className = $this->getCollection()->getEntity();

        $qb = $this->getCollection()->getQueryBuilder();

        /** @var EavEntityType $eavEntityType */
        $eavEntityType = $entityManager->getRepository(EavEntityType::class)
            ->findOneBy(['entity_type_code' => $className]);

        if (!$eavEntityType) {
            throw new Exception("EAV entity type not found for UserEntity.");
        }

        $metadata = $entityManager->getClassMetadata($className);

        foreach ($filters as $attributeCode => $value) {
            if ($metadata->hasField($attributeCode)) {
                // Direct column in Entity
                $qb->andWhere("main_table.$attributeCode LIKE :value_$attributeCode")
                    ->setParameter("value_$attributeCode", "%$value%");
            } else {
                // EAV attribute search
                $attribute = $entityManager->getRepository(EavAttribute::class)
                    ->findOneBy(['attribute_code' => $attributeCode, 'entityType' => $eavEntityType]);

                if (!$attribute) {
                    continue;
                }

                $alias = "attr_" . $attributeCode;
                if(!isset($this->joinAliases[$alias])) {
                    $this->joinAliases[$alias] = true;

                    $qb->leftJoin($attribute->getBackendType(), $alias, 'WITH', "$alias.entity_id = main_table.entity_id AND $alias.attribute_id = :attr_$attributeCode")
                        ->andWhere("$alias.value LIKE :value_$attributeCode")
                        ->setParameter("attr_$attributeCode", $attribute->getAttributeId())
                        ->setParameter("value_$attributeCode", "%$value%");
                }
            }
        }
    }

    /**
     * @param string $keyword
     * @return $this
     */
    public function addFullTextSearch(string $keyword): static
    {
        $entityManager = $this->getCollection()->getEntityManager();
        $className = $this->getCollection()->getEntity();

        $qb = $this->getCollection()->getQueryBuilder();

        $metadata = $entityManager->getClassMetadata($className);
        $orX = $qb->expr()->orX();

        foreach ($metadata->getFieldNames() as $field) {
            if (in_array($metadata->getTypeOfField($field), ['string', 'text'])) {
                $orX->add("main_table.$field LIKE :keyword");
            }
        }

        /** @var EavEntityType $eavEntityType */
        $eavEntityType = $entityManager->getRepository(EavEntityType::class)
            ->findOneBy(['entity_type_code' => $className]);

        if ($eavEntityType) {
            $attributes = $entityManager->getRepository(EavAttribute::class)
                ->findBy(['entityType' => $eavEntityType]);

            foreach ($attributes as $attribute) {
                $alias = "eav_" . md5($attribute->getBackendType());
                if(!isset($this->joinAliases[$alias])) {
                    $this->joinAliases[$alias] = true;
                    $qb->leftJoin($attribute->getBackendType(), $alias, 'WITH', "$alias.entity_id = main_table.entity_id");
                    $orX->add("$alias.value LIKE :keyword");
                }
            }
        }

        if (count($orX->getParts()) > 0) {
            $qb->andWhere($orX)
                ->setParameter("keyword", "%$keyword%");
        }

        return $this;
    }
}