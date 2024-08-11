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
use ProgramCms\UserBundle\Entity\Address\UserAddressEntity;
use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue;

/**
 * Class AbstractUserAddressEntity
 * @package ProgramCms\UserBundle\App\Eav
 */
#[MappedSuperclass]
abstract class AbstractUserAddressEntity extends AttributeValue
{
    /**
     * @var UserAddressEntity
     */
    #[ORM\ManyToOne(targetEntity: UserAddressEntity::class)]
    #[ORM\JoinColumn(name: "entity_id", referencedColumnName: "entity_id")]
    protected UserAddressEntity $entity_id;

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
     * @return UserAddressEntity
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }
}