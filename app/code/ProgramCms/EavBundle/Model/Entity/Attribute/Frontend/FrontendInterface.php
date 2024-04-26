<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Entity\Attribute\Frontend;

/**
 * Interface FrontendInterface
 * @package ProgramCms\EavBundle\Model\Entity\Attribute\Frontend
 */
interface FrontendInterface
{
    /**
     * @param string $attributeCode
     * @param object $object
     * @return mixed
     */
    public function getValue(string $attributeCode, object $object);
}