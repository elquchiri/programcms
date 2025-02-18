<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model\Db\Collection;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use ProgramCms\EavBundle\Entity\EavAttribute;
use ProgramCms\EavBundle\Entity\EavEntityType;
use ReflectionException;

/**
 * Class AbstractCollection
 * @package ProgramCms\CoreBundle\Model\Db\Collection
 */
abstract class AbstractCollection implements CollectionInterface
{
    /**
     * @var string
     */
    protected string $entity;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * @var QueryBuilder
     */
    protected QueryBuilder $_queryBuilder;

    /**
     * AbstractCollection constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
        $this->_queryBuilder = $this->entityManager->createQueryBuilder();

        // Initialize collection
        $this->_construct();
        // Initialize select operation with full data
        $this->_initSelect();
    }

    protected function _construct()
    {
        // Please override this one instead of overriding real __construct constructor
    }

    /**
     * @param string $entityClass
     */
    protected function _initEntity(string $entityClass)
    {
        $this->entity = $entityClass;
    }

    /**
     * Init SQL Select Operation
     * @return $this
     */
    protected function _initSelect()
    {
        $this->getQueryBuilder()->select('main_table')->from($this->entity, 'main_table');
        return $this;
    }

    /**
     * Run then Get Final Query Result
     * @return array
     */
    public function getData(): array
    {
        return $this->getQueryBuilder()->getQuery()->getResult();
    }

    /**
     * Get data as array, skip relations (ORM) and return them statically
     * @return array
     */
    public function getDataAsArray(): array
    {
        return $this->getQueryBuilder()->getQuery()->getArrayResult();
    }

    /**
     * Get Query Builder
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return $this->_queryBuilder;
    }

    /**
     * @param string $field
     * @return $this
     */
    public function addFieldToSelect(string $field): static
    {
        $field = explode('.', $field);
        $entityAlias = $field[0];
        $field = $field[1];

        // Get metadata for the entity
        $metadata = $this->entityManager->getClassMetadata($this->entity);

        if($field === '*') {
            // Get all mapped fields
            $mappedFields = $metadata->getFieldNames();
            foreach($mappedFields as $mappedField) {
                $this->getQueryBuilder()
                    ->addSelect($entityAlias . '.' . $mappedField);
            }
        }else {
            $this->getQueryBuilder()->addSelect($entityAlias . '.' . $field);
        }

        return $this;
    }

    /**
     * @param string $field
     * @param $value
     * @param string $filter
     * @return AbstractCollection
     */
    public function addFieldToFilter(string $field, $value, string $filter = 'eq'): static
    {
        $qb = $this->getQueryBuilder();

        // Use andWhere instead of where to accumulate conditions
        $qb->andWhere(
            $qb->expr()->$filter('main_table.' . $field, '?'.count($qb->getParameters())+1)
        )->setParameter(count($qb->getParameters())+1, $value);

        return $this;
    }

    /**
     * @param string $field
     * @param $value
     * @param string $filter
     * @return $this
     * @throws ReflectionException
     */
    public function addAttributeToFilter(string $field, $value, string $filter = 'eq'): static
    {
        $eavAttributeRepo = $this->entityManager->getRepository(EavAttribute::class);
        /** @var EavAttribute $attribute */
        $attribute = $eavAttributeRepo->findOneBy(['attribute_code' => $field]);

        if (!$attribute) {
            throw new \InvalidArgumentException("Attribute '$field' not found in EAV attributes.");
        }

        $backendType = $attribute->getBackendType(); // E.g., "ProgramCms\UserBundle\Entity\UserEntityVarchar"
        if (!class_exists($backendType)) {
            throw new \InvalidArgumentException("Backend type '$backendType' does not exist.");
        }

        $alias = 'eav_' . strtolower((new \ReflectionClass($backendType))->getShortName());
        $this->getQueryBuilder()
            ->join($backendType, $alias, 'WITH', "$alias.attribute_id = :attribute")
            ->andWhere(
                match ($filter) {
                    'like' => $this->getQueryBuilder()->expr()->like("$alias.value", ':value'),
                    'eq' => $this->getQueryBuilder()->expr()->eq("$alias.value", ':value'),
                    'neq' => $this->getQueryBuilder()->expr()->neq("$alias.value", ':value'),
                    default => throw new \InvalidArgumentException("Unsupported filter type: $filter"),
                }
            )
            ->setParameter('attribute', $attribute)
            ->setParameter('value', $filter === 'like' ? "%$value%" : $value);

        return $this;
    }

    /**
     * @param array|string $fields
     * @return $this
     * @throws ReflectionException
     */
    public function addAttributeToSelect(array|string $fields): static
    {
        $fields = (array)$fields; // Normalize input to array
        foreach ($fields as $field) {
            $eavAttributeRepo = $this->entityManager->getRepository(EavAttribute::class);
            $attribute = $eavAttributeRepo->findOneBy(['attribute_code' => $field]);

            if (!$attribute) {
                throw new \InvalidArgumentException("Attribute '$field' not found in EAV attributes.");
            }

            $backendType = $attribute->getBackendType(); // E.g., "ProgramCms\UserBundle\Entity\UserEntityVarchar"
            if (!class_exists($backendType)) {
                throw new \InvalidArgumentException("Backend type '$backendType' does not exist.");
            }

            $alias = 'eav_' . strtolower((new \ReflectionClass($backendType))->getShortName());
            $this->getQueryBuilder()
                ->leftJoin($backendType, $alias, 'WITH', "$alias.attribute = :attribute_$field")
                ->addSelect("$alias.value AS {$field}_value")
                ->setParameter("attribute_$field", $attribute);
        }

        return $this;
    }

    /**
     * @param array|string $fields
     * @param string $keyword
     * @return $this
     */
    public function addKeywordSearch(array|string $fields, string $keyword): static
    {
        $expr = $this->getQueryBuilder()->expr();
        $conditions = [];

        foreach ((array) $fields as $field) {
            $conditions[] = $expr->like('main_table.' . $field, '?1');
        }

        $this->getQueryBuilder()->andWhere(call_user_func_array([$expr, 'orX'], $conditions))
            ->setParameter(1, '%' . $keyword . '%');

        return $this;
    }

    /**
     * @return array|string
     */
    public function getSql(): array|string
    {
        return $this->getQueryBuilder()->getQuery()->getSQL();
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}