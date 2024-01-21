<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CoreBundle\Model\DataObject;

/**
 * Class Entity
 * @package ProgramCms\EavBundle\Entity
 */
#[ORM\MappedSuperclass]
class Entity extends DataObject implements EntityInterface
{
    /**
     * This is the default attribute model if no one was specified
     * in eav_attribute or eav_attribute_type
     */
    const DEFAULT_ATTRIBUTE_MODEL = EavAttribute::class;
}