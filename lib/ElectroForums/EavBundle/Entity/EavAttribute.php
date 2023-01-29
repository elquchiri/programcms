<?php


namespace ElectroForums\EavBundle\Entity;


use ElectroForums\EavBundle\Repository\EavAttributeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EavAttributeRepository::class)]
class EavAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $attribute_id = null;

    #[ORM\Column(length: 255)]
    private ?int $entity_type_id = null;

    #[ORM\Column(length: 255)]
    private ?string $attribute_code = null;

    #[ORM\Column(length: 255)]
    private ?string $backend_type = null;

    #[ORM\Column(length: 255)]
    private ?string $frontend_input = null;

    #[ORM\Column(length: 255)]
    private ?string $frontend_label = null;

    #[ORM\Column(length: 255)]
    private ?string $frontend_model = null;

    #[ORM\Column(length: 255)]
    private ?int $is_required = null;

    #[ORM\Column(length: 255)]
    private ?string $default_value = null;

    #[ORM\Column(length: 255)]
    private ?string $note = null;

    public function getAttributeId(): ?int
    {
        return $this->attribute_id;
    }

    public function setAttributeId(int $attribute_id): self
    {
        $this->attribute_id = $attribute_id;

        return $this;
    }

    public function getEntityTypeId(): ?string
    {
        return $this->entity_type_id;
    }

    public function setEntityTypeId(string $entity_type_id): self
    {
        $this->entity_type_id = $entity_type_id;

        return $this;
    }

    public function getAttributeCode(): ?string
    {
        return $this->attribute_code;
    }

    public function setAttributeCode(string $attribute_code): self
    {
        $this->attribute_code = $attribute_code;

        return $this;
    }

    public function getFrontendInput(): ?string
    {
        return $this->frontend_input;
    }

    public function setFrontendInput(string $frontend_input): self
    {
        $this->frontend_input = $frontend_input;

        return $this;
    }

    public function getFrontendLabel(): ?string
    {
        return $this->frontend_label;
    }

    public function setFrontendLabel(string $frontend_label): self
    {
        $this->frontend_label = $frontend_label;

        return $this;
    }

    public function getIsRequired(): ?string
    {
        return $this->is_required;
    }

    public function setIsRequired(string $is_required): self
    {
        $this->is_required = $is_required;

        return $this;
    }

    public function getDefaultValue(): ?string
    {
        return $this->default_value;
    }

    public function setDefaultValue(string $default_value): self
    {
        $this->default_value = $default_value;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
