<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Entity;

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
    public function setAttributeSetId(int $attribute_set_id): self
    {
        $this->attribute_set_id = $attribute_set_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEntityTypeId(): ?string
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
}
