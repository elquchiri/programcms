<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Entity\Attribute\Backend;

/**
 * Interface BackendInterface
 * @package ProgramCms\EavBundle\Model\Entity\Attribute\Backend
 */
interface BackendInterface
{
    /**
     * @param string $attributeCode
     * @param object $object
     * @return mixed
     */
    public function beforeSave(string $attributeCode, object $object);
}