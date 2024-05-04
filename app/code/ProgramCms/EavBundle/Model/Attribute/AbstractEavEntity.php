<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Attribute;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue;

/**
 * Class AbstractEavEntity
 * @package ProgramCms\EavBundle\Model\Attribute
 */
#[MappedSuperclass]
abstract class AbstractEavEntity extends AttributeValue
{
    /**
     * @var int|null
     */
    #[ORM\Column]
    protected ?int $entity_id;

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
     * @return int|null
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }
}