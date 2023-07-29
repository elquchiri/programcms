<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Entity;

use Doctrine\Common\Collections\Collection;
use ProgramCms\EavBundle\Repository\EavEntityTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EavEntityType
 * @package ProgramCms\EavBundle\Entity
 */
#[ORM\Entity(repositoryClass: EavEntityTypeRepository::class)]
class EavEntityType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $entity_type_id = null;

    #[ORM\Column(length: 255)]
    private ?string $entity_type_code = null;

    #[ORM\OneToMany(mappedBy: "entityType", targetEntity: EavAttributeSet::class)]
    private Collection $attributeSets;

    #[ORM\OneToMany(mappedBy: 'entityType', targetEntity: EavAttribute::class)]
    private Collection $attributes;

    /**
     * @return int|null
     */
    public function getEntityTypeId(): ?int
    {
        return $this->entity_type_id;
    }

    /**
     * @param int $entity_type_id
     * @return $this
     */
    public function setEntityTypeId(int $entity_type_id): self
    {
        $this->entity_type_id = $entity_type_id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEntityTypeCode(): ?string
    {
        return $this->entity_type_code;
    }

    /**
     * @param string $entity_type_code
     * @return $this
     */
    public function setEntityTypeCode(string $entity_type_code): self
    {
        $this->entity_type_code = $entity_type_code;

        return $this;
    }
}
