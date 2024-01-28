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
     * @return AbstractCollection
     */
    public function addFieldToFilter(string $field, $value): static
    {
        $this->getQueryBuilder()->where(
            $this->getQueryBuilder()->expr()->andX(
                $this->getQueryBuilder()->expr()->eq('main_table.' . $field, '?1'),
            )
        )->setParameter(1, $value);

        return $this;
    }
}