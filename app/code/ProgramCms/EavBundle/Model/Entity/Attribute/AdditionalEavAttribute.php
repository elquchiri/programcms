<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Entity\Attribute;

use Doctrine\ORM\Mapping\MappedSuperclass;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\EavBundle\Entity\EavAttribute;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AdditionalEavAttribute
 * @package ProgramCms\EavBundle\Model\Entity\Attribute
 */
#[MappedSuperclass]
abstract class AdditionalEavAttribute extends AbstractEntity implements AdditionalEavAttributeInterface
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: EavAttribute::class)]
    #[ORM\JoinColumn(name: "attribute_id", referencedColumnName: "attribute_id")]
    protected ?EavAttribute $attribute_id = null;

    /**
     * @param EavAttribute $attribute_id
     * @return $this
     */
    public function setAttributeId(EavAttribute $attribute_id): static
    {
        $this->attribute_id = $attribute_id;
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
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->attribute_id->getEntityId();
    }
}