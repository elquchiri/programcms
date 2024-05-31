<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\App\Eav;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\WebsiteBundle\App\ScopedAttributeValue;

/**
 * Class AbstractPostEntity
 * @package ProgramCms\PostBundle\App\Eav
 */
#[MappedSuperclass]
abstract class AbstractPostEntity extends ScopedAttributeValue
{
    /**
     * @var PostEntity
     */
    #[ORM\ManyToOne(targetEntity: PostEntity::class)]
    #[ORM\JoinColumn(name: "entity_id", referencedColumnName: "entity_id")]
    protected PostEntity $entity_id;

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
     * @return PostEntity
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }
}