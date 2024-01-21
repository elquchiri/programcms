<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\ResourceModel\Attribute;

use ProgramCms\EavBundle\Entity\EavEntityType;

/**
 * Class Collection
 * @package ProgramCms\EavBundle\Model\ResourceModel\Attribute
 */
abstract class Collection extends \ProgramCms\EavBundle\Model\ResourceModel\Entity\Attribute\Collection
{
    /**
     * @var EavEntityType
     */
    protected $_entityType;

    /**
     * @return mixed
     */
    abstract protected function _getEntityTypeCode();

    /**
     * @return mixed
     */
    public function getEntityTypeCode()
    {
        return $this->_getEntityTypeCode();
    }

    /**
     * @return mixed|EavEntityType|null
     */
    public function getEntityType()
    {
        if ($this->_entityType === null) {
            $this->_entityType = $this->config->getEntityType($this->_getEntityTypeCode());
        }
        return $this->_entityType;
    }

    /**
     * @return $this|Collection
     */
    protected function _initSelect()
    {
        $entityType = $this->getEntityType();
        $extraTable = $entityType->getAdditionalAttributeTable();
        $metadata = $this->entityManager->getClassMetadata($this->entity);
        $extraMetadata = $this->entityManager->getClassMetadata($extraTable);

        $mainMappedFields = $metadata->getFieldNames();

        $mainColumns = ['entity_type_table.entity_type_id'];
        foreach ($mainMappedFields as $columnName) {
            $mainColumns[] = 'main_table.' . $columnName;
        }

        $this->getQueryBuilder()
            ->select($mainColumns)
            ->from($this->entity, 'main_table');

        $extraMappedFields = $extraMetadata->getFieldNames();
        $extraColumns = [];
        foreach ($extraMappedFields as $extraColumnName) {
            $extraColumns[] = 'additional_table.' . $extraColumnName;
        }

        $this->getQueryBuilder()
            ->innerJoin(
                $extraTable,
                'additional_table',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'additional_table.attribute_id = main_table.attribute_id'
            )
            ->innerJoin(
                'main_table.entityType',
                'entity_type_table'
            )
            ->where(
                $this->getQueryBuilder()->expr()->andX(
                    $this->getQueryBuilder()->expr()->eq('main_table.entityType', '?1'),
                )
            )
            ->setParameter(1, $entityType)
            ->addSelect($extraColumns);

        return $this;
    }

    /**
     * @param $type
     * @return $this|Collection
     */
    public function setEntityTypeFilter($type)
    {
        return $this;
    }

}