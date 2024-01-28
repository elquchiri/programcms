<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\EntityManager;

use ProgramCms\EavBundle\Model\Entity\Entity;

/**
 * Interface AttributeInterface
 * @package ProgramCms\EavBundle\Model\EntityManager
 */
interface AttributeInterface
{
    /**
     * @param Entity $entityData
     * @return mixed
     */
    public function execute(Entity $entityData);
}