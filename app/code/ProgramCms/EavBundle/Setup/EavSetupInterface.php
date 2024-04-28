<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Setup;

/**
 * Interface EavSetupInterface
 * @package ProgramCms\EavBundle\Setup
 */
interface EavSetupInterface
{
    /**
     * @param string $entityType
     * @param string $code
     * @param array $attributeData
     * @return mixed
     */
    public function addAttribute(string $entityType, string $code, array $attributeData);

    /**
     * @param string $entityTypeCode
     * @param array $entityData
     * @return mixed
     */
    public function addEntityType(string $entityTypeCode, array $entityData);
}