<?php


namespace ProgramCms\EavBundle\Entity;


use ProgramCms\EavBundle\Repository\EavEntityLabelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EavEntityLabelRepository::class)]
class EavAttributeLabel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $attribute_label_id = null;

    #[ORM\Column(length: 255)]
    private ?int $attribute_id = null;

    #[ORM\Column(length: 255)]
    private ?int $website_view_id = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    public function getAttributeLabelId(): ?string
    {
        return $this->attribute_label_id;
    }

    public function setAttributeLabelId(int $attribute_label_id): self
    {
        $this->attribute_label_id = $attribute_label_id;

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

    public function getWebsiteViewId(): ?string
    {
        return $this->website_view_id;
    }

    public function setWebsiteViewId(string $website_view_id): self
    {
        $this->website_view_id = $website_view_id;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
