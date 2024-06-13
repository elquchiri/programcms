<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Entity\Attribute\Frontend;

/**
 * Class Image
 * @package ProgramCms\EavBundle\Model\Entity\Attribute\Frontend
 */
class Image extends AbstractFrontend
{

    /**
     * @param string $attributeCode
     * @param $value
     * @param object $object
     * @return string
     */
    public function getValue(string $attributeCode, $value, object $object): string
    {
        return $value;
    }
}