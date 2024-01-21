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
use ProgramCms\EavBundle\EventListener\EntityListener;

/**
 * Class Entity
 * @package ProgramCms\CoreBundle\Entity
 */
#[ORM\EntityListeners([EntityListener::class])]
class Entity extends DataObject implements EntityInterface
{

}