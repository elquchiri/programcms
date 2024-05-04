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
use ProgramCms\PostBundle\Entity\Post;
use ProgramCms\WebsiteBundle\App\ScopedAttributeValue;

/**
 * Class AbstractPostEntity
 * @package ProgramCms\PostBundle\App\Eav
 */
#[MappedSuperclass]
abstract class AbstractPostEntity extends ScopedAttributeValue
{
    /**
     * @var Post
     */
    #[ORM\ManyToOne(targetEntity: Post::class)]
    #[ORM\JoinColumn(name: "entity_id", referencedColumnName: "entity_id")]
    protected Post $entity_id;

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
     * @return Post
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }
}