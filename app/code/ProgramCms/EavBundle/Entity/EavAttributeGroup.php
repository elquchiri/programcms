<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Entity;

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
}
