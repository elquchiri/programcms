<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Entity;

use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use ProgramCms\EavBundle\Entity\EavEntityType;

/**
 * Class Entity
 * @package ProgramCms\EavBundle\Model\Entity
 */
#[MappedSuperclass, HasLifecycleCallbacks]
class Entity extends \ProgramCms\CoreBundle\Model\Db\Entity\Entity implements EntityInterface
{
    /**
     * @var EavEntityType|null
     */
    protected ?EavEntityType $entityType = null;

    /**
     * @param EavEntityType $entityType
     * @return $this
     */
    public function setEntityType(EavEntityType $entityType): static
    {
        $this->entityType = $entityType;
        return $this;
    }

    /**
     * @return EavEntityType|null
     */
    public function getEntityType(): ?EavEntityType
    {
        return $this->entityType;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        $namingStrategy = new UnderscoreNamingStrategy();
        return $namingStrategy->classToTableName(static::class);
    }
}