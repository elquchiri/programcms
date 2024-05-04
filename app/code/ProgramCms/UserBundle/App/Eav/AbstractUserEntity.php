<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\App\Eav;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue;

/**
 * Class AbstractUserEntity
 * @package ProgramCms\CatalogBundle\App\Eav
 */
#[MappedSuperclass]
abstract class AbstractUserEntity extends AttributeValue
{
    /**
     * @var UserEntity
     */
    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(name: "entity_id", referencedColumnName: "entity_id")]
    protected UserEntity $entity_id;

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
     * @return UserEntity
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }
}