<?php


namespace ElectroForums\EavBundle\Entity;


use ElectroForums\EavBundle\Repository\EavAttributeSetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EavAttributeSetRepository::class)]
class EavAttributeSet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $attribute_set_id = null;

    #[ORM\Column(length: 255)]
    private ?int $entity_type_id = null;

    #[ORM\Column(length: 255)]
    private ?string $attribute_set_name = null;

    public function getAttributeSetId(): ?int
    {
        return $this->attribute_set_id;
    }

    public function setAttributeSetId(int $attribute_set_id): self
    {
        $this->attribute_set_id = $attribute_set_id;

        return $this;
    }

    public function getEntityTypeId(): ?string
    {
        return $this->entity_type_id;
    }

    public function setEntityTypeId(int $entity_type_id): self
    {
        $this->entity_type_id = $entity_type_id;

        return $this;
    }

    public function getAttributeSetName(): ?string
    {
        return $this->attribute_set_name;
    }

    public function setAttributeSetName(string $attribute_set_name): self
    {
        $this->attribute_set_name = $attribute_set_name;

        return $this;
    }
}
