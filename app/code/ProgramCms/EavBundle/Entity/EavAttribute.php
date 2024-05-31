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
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\EavBundle\Model\Entity\Attribute\AdditionalEavAttribute;
use ProgramCms\EavBundle\Repository\EavAttributeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EavAttribute
 * @package ProgramCms\EavBundle\Entity
 */
#[ORM\Entity(repositoryClass: EavAttributeRepository::class)]
class EavAttribute extends AbstractEntity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $attribute_id = null;

    /**
     * @var EavEntityType
     */
    #[ORM\ManyToOne(targetEntity: EavEntityType::class, inversedBy: 'attributes')]
    #[ORM\JoinColumn(name: 'entity_type_id', referencedColumnName: 'entity_type_id')]
    private EavEntityType $entityType;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $attribute_code = null;

    /**
     * Determines which table should save attribute value
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $backend_type = null;

    /**
     * validate and add additional processing
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $backend_model = null;

    /**
     * Frontend field type (text, date, ...)
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $frontend_input = null;

    /**
     * Field Label
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $frontend_label = null;

    /**
     * format field frontend data before getting value
     * @var string|null
     */
    #[ORM\Column(nullable: true)]
    private ?string $frontend_model = null;

    /**
     * @var int|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?int $is_required = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $default_value = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'attribute', targetEntity: EavAttributeLabel::class)]
    private Collection $labels;

    /**
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: EavAttributeGroup::class, mappedBy: 'attributes')]
    private Collection $groups;

    /**
     * @var AdditionalEavAttribute|null
     */
    #[ORM\JoinColumn(name: "attribute_id", referencedColumnName: "attribute_id")]
    private ?AdditionalEavAttribute $additionalAttribute = null;

    /**
     * EavAttribute constructor.
     * @param array $data
     */
    public function __construct(
        array $data = []
    )
    {
        parent::__construct($data);
        $this->groups = new ArrayCollection();
        $this->labels = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getAttributeId(): ?int
    {
        return $this->attribute_id;
    }

    /**
     * @param int $attribute_id
     * @return $this
     */
    public function setAttributeId(int $attribute_id): self
    {
        $this->attribute_id = $attribute_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->attribute_id;
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
    public function getAttributeCode(): ?string
    {
        return $this->attribute_code;
    }

    /**
     * @param string $attribute_code
     * @return $this
     */
    public function setAttributeCode(string $attribute_code): self
    {
        $this->attribute_code = $attribute_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getBackendType(): string
    {
        return $this->backend_type;
    }

    /**
     * @param string $backendType
     * @return $this
     */
    public function setBackendType(string $backendType): self
    {
        $this->backend_type = $backendType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBackendModel(): ?string
    {
        return $this->backend_model;
    }

    /**
     * @param string $backendModel
     * @return $this
     */
    public function setBackendModel(string $backendModel): static
    {
        $this->backend_model = $backendModel;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFrontendInput(): ?string
    {
        return $this->frontend_input;
    }

    /**
     * @param string $frontend_input
     * @return $this
     */
    public function setFrontendInput(string $frontend_input): self
    {
        $this->frontend_input = $frontend_input;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFrontendLabel(): ?string
    {
        return $this->frontend_label;
    }

    /**
     * @param string $frontend_label
     * @return $this
     */
    public function setFrontendLabel(string $frontend_label): self
    {
        $this->frontend_label = $frontend_label;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFrontendModel(): ?string
    {
        return $this->frontend_model;
    }

    /**
     * @param string $frontendModel
     * @return $this
     */
    public function setFrontendModel(string $frontendModel): static
    {
        $this->frontend_model = $frontendModel;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIsRequired(): ?string
    {
        return $this->is_required;
    }

    /**
     * @param string $is_required
     * @return $this
     */
    public function setIsRequired(string $is_required): self
    {
        $this->is_required = $is_required;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDefaultValue(): ?string
    {
        return $this->default_value;
    }

    /**
     * @param string $default_value
     * @return $this
     */
    public function setDefaultValue(string $default_value): self
    {
        $this->default_value = $default_value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string $note
     * @return $this
     */
    public function setNote(string $note): self
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    /**
     * @param EavAttributeGroup $group
     * @return $this
     */
    public function addGroup(EavAttributeGroup $group): static
    {
        if(!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addAttribute($this);
        }

        return $this;
    }

    /**
     * @param EavAttributeGroup $group
     * @return $this
     */
    public function removeGroup(EavAttributeGroup $group): static
    {
        if($this->groups->removeElement($group)) {
            if(count($group->getAttributes()) > 0) {
                $group->removeAttribute($this);
            }
        }
        return $this;
    }

    /**
     * @return Collection
     */
    public function getLabels(): Collection
    {
        return $this->labels;
    }

    /**
     * @param EavAttributeLabel $label
     * @return $this
     */
    public function addLabel(EavAttributeLabel $label): static
    {
        if(!$this->labels->contains($label)) {
            $this->labels[] = $label;
        }
        return $this;
    }

    /**
     * @param EavAttributeLabel $label
     * @return $this
     */
    public function removeLabel(EavAttributeLabel $label): static
    {
        $this->labels->removeElement($label);
        return $this;
    }

    /**
     * @param $additionAttribute
     * @return $this
     */
    public function setAdditionalAttribute($additionAttribute): static
    {
        $this->additionalAttribute = $additionAttribute;
        return $this;
    }

    /**
     * @return AdditionalEavAttribute|null
     */
    public function getAdditionalAttribute(): ?AdditionalEavAttribute
    {
        return $this->additionalAttribute;
    }
}
