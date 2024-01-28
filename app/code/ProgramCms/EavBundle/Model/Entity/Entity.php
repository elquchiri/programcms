<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\MappedSuperclass;
use ProgramCms\EavBundle\Entity\EavAttribute;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use DateTime;
use ProgramCms\EavBundle\Entity\EavEntityType;

#[MappedSuperclass, HasLifecycleCallbacks]
abstract class Entity extends \ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected ?int $entity_id = null;

    #[ORM\Column(type: 'datetime')]
    protected ?DateTime $created_at = null;

    #[ORM\Column(type: 'datetime')]
    protected ?DateTime $updated_at = null;

    /**
     * @var EavEntityType|null
     */
    protected ?EavEntityType $entityType = null;

    /**
     * This is the default attribute model if none was specified
     * in eav_attribute or eav_attribute_type tables
     */
    const DEFAULT_ATTRIBUTE_MODEL = EavAttribute::class;

    /**
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->entity_id;
    }

    /**
     * @param int $entity_id
     * @return $this
     */
    public function setEntityId(int $entity_id): self
    {
        $this->entity_id = $entity_id;
        return $this;
    }

    /**
     * @param EavEntityType $entityType
     * @return $this
     */
    public function setEntityType(EavEntityType $entityType): static
    {
        $this->entityType = $entityType;
        return $this;
    }

    /**
     * @return EavEntityType|null
     */
    public function getEntityType(): ?EavEntityType
    {
        return $this->entityType;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updated_at = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        $namingStrategy = new UnderscoreNamingStrategy();
        return $namingStrategy->classToTableName(static::class);
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps(): void
    {
        $now = new DateTime();
        $this->setUpdatedAt($now);
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($now);
        }
    }
}