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
use ProgramCms\EavBundle\Repository\EavAttributeSetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EavAttributeSet
 * @package ProgramCms\EavBundle\Entity
 */
#[ORM\Entity(repositoryClass: EavAttributeSetRepository::class)]
class EavAttributeSet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $attribute_set_id = null;

    #[ORM\Column(length: 255)]
    private ?string $attribute_set_name = null;

    #[ORM\ManyToOne(targetEntity: EavEntityType::class, inversedBy: 'attributeSets')]
    #[ORM\JoinColumn(name: 'entity_type_id', referencedColumnName: 'entity_type_id')]
    private ?EavEntityType $entityType = null;

    #[ORM\OneToMany(mappedBy: 'attributeSet', targetEntity: EavAttributeGroup::class)]
    private Collection $attributeSetGroups;

    /**
     * EavAttributeSet constructor.
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getAttributeSetId(): ?int
    {
        return $this->attribute_set_id;
    }

    /**
     * @param int $attribute_set_id
     * @return $this
     */
    public function setAttributeSetId(int $attributeSetId): self
    {
        $this->attribute_set_id = $attributeSetId;
        return $this;
    }

    /**
     * @return EavEntityType
     */
    public function getEntityType(): EavEntityType
    {
        return $this->entityType;
    }

    /**
     * @param EavEntityType $entityType
     * @return $this
     */
    public function setEntityType(EavEntityType $entityType): self
    {
        $this->entityType = $entityType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttributeSetName(): ?string
    {
        return $this->attribute_set_name;
    }

    /**
     * @param string $attribute_set_name
     * @return $this
     */
    public function setAttributeSetName(string $attribute_set_name): self
    {
        $this->attribute_set_name = $attribute_set_name;
        return $this;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getgroups(): ArrayCollection|Collection
    {
        return $this->groups;
    }

    /**
     * @param EavAttributeGroup $attributeGroup
     * @return $this
     */
    public function addAttributeSetGroup(EavAttributeGroup $attributeGroup): self
    {
        if(!$this->groups->contains($attributeGroup)) {
            $this->groups[] = $attributeGroup;
            $attributeGroup->setAttributeSet($this);
        }

        return $this;
    }

    /**
     * @param EavAttributeGroup $attributeGroup
     * @return $this
     */
    public function removeAttributeSetGroup(EavAttributeGroup $attributeGroup): self
    {
        if($this->groups->removeElement($attributeGroup)) {
            if($attributeGroup->getAttributeSet() === $this) {
                $attributeGroup->setAttributeSet(null);
            }
        }

        return $this;
    }
}
