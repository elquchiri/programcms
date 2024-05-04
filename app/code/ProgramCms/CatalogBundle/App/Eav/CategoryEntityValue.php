<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\App\Eav;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\WebsiteBundle\App\ScopedAttributeValue;

/**
 * Class CategoryEntityValue
 * @package ProgramCms\CatalogBundle\App\Eav
 */
#[MappedSuperclass]
abstract class CategoryEntityValue extends ScopedAttributeValue
{
    /**
     * @var CategoryEntity
     */
    #[ORM\ManyToOne(targetEntity: CategoryEntity::class)]
    #[ORM\JoinColumn(name: "entity_id", referencedColumnName: "entity_id")]
    protected CategoryEntity $entity_id;

    /**
     * @param $entityId
     * @return $this
     */
    public function setEntityId($entityId): static
    {
        $this->entity_id = $entityId;
        return $this;
    }

    /**
     * @return CategoryEntity
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }
}