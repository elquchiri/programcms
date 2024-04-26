<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Attribute\Frontend;

/**
 * Interface FrontendInterface
 * @package ProgramCms\ConfigBundle\Model\Attribute\Frontend
 */
interface FrontendInterface
{
    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function getValue($field, $value);
}