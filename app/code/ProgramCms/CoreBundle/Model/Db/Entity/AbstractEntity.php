<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model\Db\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CoreBundle\Model\DataObject;

/**
 * Class AbstractEntity
 * @package ProgramCms\CoreBundle\Entity
 */
#[ORM\MappedSuperclass]
abstract class AbstractEntity extends DataObject implements EntityInterface
{

}