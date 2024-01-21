<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\ResourceModel\Entity\Attribute;

use Doctrine\ORM\EntityManagerInterface;
use ProgramCms\EavBundle\Entity\EavAttribute;
use ProgramCms\EavBundle\Entity\EavEntityType;
use ProgramCms\EavBundle\Model\Config;

/**
 * Class Collection
 * @package ProgramCms\EavBundle\Model\ResourceModel\Entity\Attribute
 */
class Collection extends \ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection
{
    /**
     * @var Config
     */
    protected Config $config;

    /**
     * Collection constructor.
     * @param EntityManagerInterface $entityManager
     * @param Config $config
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        Config $config
    )
    {
        $this->config = $config;
        parent::__construct($entityManager);
    }

    /**
     * Initialize Collection
     */
    protected function _construct()
    {
        $this->_initEntity(EavAttribute::class);
    }

    /**
     * @return $this|Collection
     */
    protected function _initSelect()
    {
        $this->getQueryBuilder()
            ->select('main_table')
            ->from($this->entity, 'main_table');

        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setEntityTypeFilter($type)
    {
        if($type instanceof EavEntityType) {
            $this->getQueryBuilder()
                ->where(
                    $this->getQueryBuilder()->expr()->andX(
                        $this->getQueryBuilder()->expr()->eq('main_table.entityType', '?1'),
                    )
                )->setParameter(1, $type);

            if(!empty($type->getAdditionalAttributeTable())) {
                $this->getQueryBuilder()
                    ->innerJoin(
                        $type->getAdditionalAttributeTable(),
                        'additional_table',
                        \Doctrine\ORM\Query\Expr\Join::WITH,
                        'additional_table.attribute_id = main_table.attribute_id'
                    );
            }
        }
        return $this;
    }
}