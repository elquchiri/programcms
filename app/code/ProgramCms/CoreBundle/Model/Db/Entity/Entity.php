<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model\Db\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Class Entity
 * @package ProgramCms\CoreBundle\Entity
 */
class Entity extends AbstractEntity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected ?int $entity_id = null;

    /**
     * @var DateTime|null
     */
    #[ORM\Column(type: 'datetime')]
    protected ?DateTime $created_at = null;

    /**
     * @var DateTime|null
     */
    #[ORM\Column(type: 'datetime')]
    protected ?DateTime $updated_at = null;

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
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    /**
     * @param DateTime|null $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt = null): self
    {
        $this->created_at = $createdAt ?? new DateTime();
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
     * @param DateTime|null $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTime $updatedAt = null): self
    {
        $this->updated_at = $updatedAt ?? new DateTime();
        return $this;
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