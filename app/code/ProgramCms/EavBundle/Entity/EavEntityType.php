<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\EavBundle\Repository\EavEntityTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EavEntityType
 * @package ProgramCms\EavBundle\Entity
 */
#[ORM\Entity(repositoryClass: EavEntityTypeRepository::class)]
class EavEntityType extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $entity_type_id = null;

    #[ORM\Column(length: 255)]
    private ?string $entity_type_code = null;

    #[ORM\Column(length: 255)]
    private ?string $additional_attribute_table = null;

    #[ORM\OneToMany(mappedBy: "entityType", targetEntity: EavAttributeSet::class)]
    private Collection $attributeSets;

    #[ORM\OneToMany(mappedBy: 'entityType', targetEntity: EavAttribute::class)]
    private Collection $attributes;

    /**
     * EavEntityType constructor.
     */
    public function __construct()
    {
        $this->attributeSets = new ArrayCollection();
        $this->attributes = new ArrayCollection();
    }

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

    /**
     * @param string $additional_attribute_table
     * @return $this
     */
    public function setAdditionalAttributeTable(string $additional_attribute_table): static
    {
        $this->additional_attribute_table = $additional_attribute_table;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdditionalAttributeTable(): ?string
    {
        return $this->additional_attribute_table;
    }

    /**
     * @return Collection
     */
    public function getAttributeSets(): Collection
    {
        return $this->attributeSets;
    }

    /**
     * @param EavAttributeSet $attributeSet
     * @return $this
     */
    public function addAttributeSet(EavAttributeSet $attributeSet): self
    {
        if (!$this->attributeSets->contains($attributeSet)) {
            $this->attributeSets[] = $attributeSet;
            $attributeSet->setEntityType($this);
        }

        return $this;
    }

    /**
     * @param EavAttributeSet $attributeSet
     * @return $this
     */
    public function removeAttributeSet(EavAttributeSet $attributeSet): self
    {
        if ($this->attributeSets->removeElement($attributeSet)) {
            // Set the owning side to null to prevent orphaned entities
            if ($attributeSet->getEntityType() === $this) {
                $attributeSet->setEntityType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    /**
     * @param EavAttribute $attribute
     * @return $this
     */
    public function addAttribute(EavAttribute $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
            $attribute->setEntityType($this);
        }

        return $this;
    }

    /**
     * @param EavAttribute $attribute
     * @return $this
     */
    public function removeAttribute(EavAttribute $attribute): self
    {
        if ($this->attributes->removeElement($attribute)) {
            // Set the owning side to null to prevent orphaned entities
            if ($attribute->getEntityType() === $this) {
                $attribute->setEntityType(null);
            }
        }

        return $this;
    }
}
