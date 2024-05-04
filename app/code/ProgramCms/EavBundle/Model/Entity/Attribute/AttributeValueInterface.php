<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Entity\Attribute;

use ProgramCms\EavBundle\Entity\EavAttribute;

/**
 * Interface AttributeValueInterface
 * @package ProgramCms\EavBundle\Model\Entity\Attribute
 */
interface AttributeValueInterface
{
    /**
     * @param int $valueId
     * @return $this
     */
    public function setValueId(int $valueId): static;

    /**
     * @return int|null
     */
    public function getValueId(): ?int;

    /**
     * @param EavAttribute $attribute
     * @return $this
     */
    public function setAttributeId(EavAttribute $attribute): static;

    /**
     * @return EavAttribute|null
     */
    public function getAttributeId(): ?EavAttribute;

    /**
     * @param $entityId
     * @return $this
     */
    public function setEntityId($entityId): static;

    /**
     * @return mixed
     */
    public function getEntityId();

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue(mixed $value): static;

    /**
     * @return mixed
     */
    public function getValue(): mixed;
}