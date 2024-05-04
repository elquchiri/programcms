<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Entity\Attribute;

use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\EavBundle\Entity\EavAttribute;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AttributeValue
 * @package ProgramCms\EavBundle\Model\Entity\Attribute
 */
#[MappedSuperclass]
abstract class AttributeValue extends AbstractEntity implements AttributeValueInterface
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $value_id = null;

    /**
     * @var EavAttribute|null
     */
    #[ORM\ManyToOne(targetEntity: EavAttribute::class)]
    #[ORM\JoinColumn(name: "attribute_id", referencedColumnName: "attribute_id")]
    protected ?EavAttribute $attribute_id = null;

    /**
     * @param int $valueId
     * @return AttributeValue
     */
    public function setValueId(int $valueId): static
    {
        $this->value_id = $valueId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getValueId(): ?int
    {
        return $this->value_id;
    }

    /**
     * @param EavAttribute $attribute
     * @return $this
     */
    public function setAttributeId(EavAttribute $attribute): static
    {
        $this->attribute_id = $attribute;
        return $this;
    }

    /**
     * @return EavAttribute|null
     */
    public function getAttributeId(): ?EavAttribute
    {
        return $this->attribute_id;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    abstract public function setValue(mixed $value): static;

    /**
     * @return mixed
     */
    abstract public function getValue(): mixed;
}