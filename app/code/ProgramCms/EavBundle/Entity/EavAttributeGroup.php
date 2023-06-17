<?php


namespace ProgramCms\EavBundle\Entity;


use ProgramCms\EavBundle\Repository\EavAttributeGroupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EavAttributeGroupRepository::class)]
class EavAttributeGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $attribute_group_id = null;

    #[ORM\Column]
    private ?int $attribute_set_id = null;

    #[ORM\Column(length: 255)]
    private ?string $attribute_group_name = null;

    #[ORM\Column(length: 255)]
    private ?string $attribute_group_code = null;

    public function getAttributeGroupId(): ?int
    {
        return $this->attribute_group_id;
    }

    public function setAttributeGroupId(int $attribute_group_id): self
    {
        $this->attribute_group_id = $attribute_group_id;

        return $this;
    }

    public function getAttributeSetId(): ?int
    {
        return $this->attribute_set_id;
    }

    public function setAttributeSetId(int $attribute_set_id): self
    {
        $this->attribute_set_id = $attribute_set_id;

        return $this;
    }

    public function getAttributeGroupName(): ?string
    {
        return $this->attribute_group_name;
    }

    public function setAttributeGroupName(string $attribute_group_name): self
    {
        $this->attribute_group_name = $attribute_group_name;

        return $this;
    }

    public function getAttributeGroupCode(): ?string
    {
        return $this->attribute_group_code;
    }

    public function setAttributeGroupCode(string $attribute_group_code): self
    {
        $this->attribute_group_code = $attribute_group_code;

        return $this;
    }
}
