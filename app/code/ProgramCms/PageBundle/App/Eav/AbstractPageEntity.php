<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\App\Eav;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use ProgramCms\PageBundle\Entity\PageEntity;
use ProgramCms\WebsiteBundle\App\ScopedAttributeValue;

/**
 * Class AbstractPageEntity
 * @package ProgramCms\PageBundle\App\Eav
 */
#[MappedSuperclass]
abstract class AbstractPageEntity extends ScopedAttributeValue
{
    /**
     * @var PageEntity
     */
    #[ORM\ManyToOne(targetEntity: PageEntity::class)]
    #[ORM\JoinColumn(name: "entity_id", referencedColumnName: "entity_id")]
    protected PageEntity $entity_id;

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
     * @return PageEntity
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }
}