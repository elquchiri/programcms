<?php


namespace ElectroForums\EavBundle\Entity;


use ElectroForums\EavBundle\Repository\EavEntityTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EavEntityTypeRepository::class)]
class EavEntityAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $entity_attribute_id = null;

    #[ORM\Column(length: 255)]
    private ?int $entity_type_id = null;

    #[ORM\Column(length: 255)]
    private ?int $attribute_group_id = null;

    #[ORM\Column(length: 255)]
    private ?int $attribute_set_id = null;

    #[ORM\Column(length: 255)]
    private ?int $attribute_id = null;

    public function getEntityAttributeId(): ?int
    {
        return $this->entity_attribute_id;
    }

    public function setEntityAttributeId(int $entity_attribute_id): self
    {
        $this->entity_attribute_id = $entity_attribute_id;

        return $this;
    }

    public function getEntityTypeId(): ?int
    {
        return $this->entity_type_id;
    }

    public function setEntityTypeId(int $entity_type_id): self
    {
        $this->entity_type_id = $entity_type_id;

        return $this;
    }

    public function getAttributeGroupId(): ?int
    {
        return $this->attribute_group_id;
    }

    public function setAttributeGroupId(int $attribute_group_id): self
    {
        $this->attribute_group_id = $attribute_group_id;

        return $this;
    }

    public function getAttributeSetId(): ?string
    {
        return $this->attribute_set_id;
    }

    public function setAttributeSetId(string $attribute_set_id): self
    {
        $this->attribute_set_id = $attribute_set_id;

        return $this;
    }

    public function getAttributeId(): ?string
    {
        return $this->attribute_id;
    }

    public function setAttributeId(string $attribute_id): self
    {
        $this->attribute_id = $attribute_id;

        return $this;
    }
}