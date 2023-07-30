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
use ProgramCms\EavBundle\Repository\EavAttributeGroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EavAttributeGroup
 * @package ProgramCms\EavBundle\Entity
 */
#[ORM\Entity(repositoryClass: EavAttributeGroupRepository::class)]
class EavAttributeGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $attribute_group_id = null;

    #[ORM\ManyToOne(targetEntity: EavAttributeSet::class, inversedBy: 'attributeSetGroups')]
    #[ORM\JoinColumn(name: 'attribute_set_id', referencedColumnName: 'attribute_set_id')]
    private ?EavAttributeSet $attributeSet = null;

    #[ORM\Column(length: 255)]
    private ?string $attribute_group_name = null;

    #[ORM\Column(length: 255)]
    private ?string $attribute_group_code = null;

    #[ORM\JoinTable(name: 'eav_attribute_group_relation')]
    #[ORM\ManyToMany(targetEntity: EavAttribute::class, inversedBy: 'groups')]
    #[ORM\JoinColumn(name: 'attribute_group_id', referencedColumnName: 'attribute_group_id')]
    #[ORM\InverseJoinColumn(name: 'attribute_id', referencedColumnName: 'attribute_id')]
    private Collection $attributes;

    /**
     * EavAttributeGroup constructor.
     */
    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getAttributeGroupId(): ?int
    {
        return $this->attribute_group_id;
    }

    /**
     * @param int $attribute_group_id
     * @return $this
     */
    public function setAttributeGroupId(int $attribute_group_id): self
    {
        $this->attribute_group_id = $attribute_group_id;
        return $this;
    }

    /**
     * @return EavAttributeSet
     */
    public function getAttributeSet(): EavAttributeSet
    {
        return $this->attributeSet;
    }

    /**
     * @param EavAttributeSet $attributeSet
     * @return $this
     */
    public function setAttributeSet(EavAttributeSet $attributeSet): self
    {
        $this->attributeSet = $attributeSet;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttributeGroupName(): ?string
    {
        return $this->attribute_group_name;
    }

    /**
     * @param string $attribute_group_name
     * @return $this
     */
    public function setAttributeGroupName(string $attribute_group_name): self
    {
        $this->attribute_group_name = $attribute_group_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttributeGroupCode(): ?string
    {
        return $this->attribute_group_code;
    }

    /**
     * @param string $attribute_group_code
     * @return $this
     */
    public function setAttributeGroupCode(string $attribute_group_code): self
    {
        $this->attribute_group_code = $attribute_group_code;
        return $this;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getAttributes(): ArrayCollection|Collection
    {
        return $this->attributes;
    }

    /**
     * @param EavAttribute $attribute
     * @return $this
     */
    public function addAttribute(EavAttribute $attribute): static
    {
        if(!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
        }

        return $this;
    }

    /**
     * @param EavAttribute $attribute
     * @return $this
     */
    public function removeAttribute(EavAttribute $attribute): static
    {
        $this->attributes->removeElement($attribute);
        return $this;
    }
}
