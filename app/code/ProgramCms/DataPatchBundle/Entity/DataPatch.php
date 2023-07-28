<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DataPatchBundle\Entity;

use ProgramCms\DataPatchBundle\Repository\DataPatchRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DataPatch
 * @package ProgramCms\DataPatchBundle\Entity
 */
#[ORM\Entity(repositoryClass: DataPatchRepository::class)]
class DataPatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $entity_id = null;

    #[ORM\Column(length: 255)]
    private ?string $patch_name = null;

    #[ORM\Column(length: 255)]
    private ?string $created_at = null;

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
     * @return string|null
     */
    public function getPatchName(): ?string
    {
        return $this->patch_name;
    }

    /**
     * @param string $patchName
     * @return $this
     */
    public function setPatchName(string $patchName): self
    {
        $this->patch_name = $patchName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}