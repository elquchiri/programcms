<?php


namespace ElectroForums\EavBundle\Entity;


use ElectroForums\EavBundle\Repository\EavEntityTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EavEntityTypeRepository::class)]
class EavEntityType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $entity_type_id = null;

    #[ORM\Column(length: 255)]
    private ?string $entity_type_code = null;

    public function getEntityTypeId(): ?int
    {
        return $this->entity_type_id;
    }

    public function setEntityTypeId(int $entity_type_id): self
    {
        $this->entity_type_id = $entity_type_id;

        return $this;
    }

    public function getEntityTypeCode(): ?string
    {
        return $this->entity_type_code;
    }

    public function setEntityTypeCode(string $entity_type_code): self
    {
        $this->entity_type_code = $entity_type_code;

        return $this;
    }
}
