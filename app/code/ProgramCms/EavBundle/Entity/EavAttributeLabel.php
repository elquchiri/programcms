<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Entity;

use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\EavBundle\Repository\EavAttributeLabelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EavAttributeLabel
 * @package ProgramCms\EavBundle\Entity
 */
#[ORM\Entity(repositoryClass: EavAttributeLabelRepository::class)]
class EavAttributeLabel extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $attribute_label_id = null;

    #[ORM\ManyToOne(targetEntity: EavAttribute::class, inversedBy: 'labels')]
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
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->attribute_label_id;
    }

    /**
     * @return EavAttribute
     */
    public function getAttribute(): EavAttribute
    {
        return $this->attribute;
    }

    /**
     * @param EavAttribute $attribute
     * @return $this
     */
    public function setAttribute(EavAttribute $attribute): self
    {
        $this->attribute = $attribute;
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
