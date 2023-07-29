<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Entity;

use ProgramCms\EavBundle\Repository\EavEntityLabelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EavAttributeLabel
 * @package ProgramCms\EavBundle\Entity
 */
#[ORM\Entity(repositoryClass: EavEntityLabelRepository::class)]
class EavAttributeLabel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $attribute_label_id = null;

    #[ORM\ManyToOne(targetEntity: EavAttribute::class, inversedBy: 'attributeLabels')]
    #[ORM\JoinColumn(name: 'attribute_id', referencedColumnName: 'attribute_id')]
    private ?EavAttribute $attribute = null;

    #[ORM\Column(length: 255)]
    private ?int $website_view_id = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    /**
     * @return string|null
     */
    public function getAttributeLabelId(): ?string
    {
        return $this->attribute_label_id;
    }

    /**
     * @param int $attribute_label_id
     * @return $this
     */
    public function setAttributeLabelId(int $attribute_label_id): self
    {
        $this->attribute_label_id = $attribute_label_id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAttributeId(): ?string
    {
        return $this->attribute_id;
    }

    /**
     * @param string $attribute_id
     * @return $this
     */
    public function setAttributeId(string $attribute_id): self
    {
        $this->attribute_id = $attribute_id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsiteViewId(): ?string
    {
        return $this->website_view_id;
    }

    /**
     * @param string $website_view_id
     * @return $this
     */
    public function setWebsiteViewId(string $website_view_id): self
    {
        $this->website_view_id = $website_view_id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
