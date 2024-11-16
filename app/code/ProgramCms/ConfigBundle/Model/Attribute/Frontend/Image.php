<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Attribute\Frontend;

/**
 * Class Image
 * @package ProgramCms\ConfigBundle\Model\Attribute\Frontend
 */
class Image extends AbstractFrontend
{
    /**
     * @param $field
     * @param $value
     * @return string
     */
    public function getValue($field, $value): string
    {
        return $value;
    }
}