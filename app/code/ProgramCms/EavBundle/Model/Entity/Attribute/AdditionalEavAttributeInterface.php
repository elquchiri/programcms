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
 * Interface AdditionalEavAttributeInterface
 * @package ProgramCms\EavBundle\Model\Entity\Attribute
 */
interface AdditionalEavAttributeInterface
{
    /**
     * @param EavAttribute $attribute_id
     * @return $this
     */
    public function setAttributeId(EavAttribute $attribute_id): static;

    /**
     * @return EavAttribute|null
     */
    public function getAttributeId(): ?EavAttribute;
}