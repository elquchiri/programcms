<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity\Group;

use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\UserBundle\Repository\Group\UserGroupPermissionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Permission
 * @package ProgramCms\UserBundle\Entity\Group
 */
#[ORM\Entity(repositoryClass: UserGroupPermissionRepository::class)]
class UserGroupPermission extends AbstractEntity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $permission_id = null;

    /**
     * @var UserGroup|null
     */
    #[ORM\ManyToOne(targetEntity: UserGroup::class)]
    #[ORM\JoinColumn(name: 'group_id', referencedColumnName: 'group_id')]
    private ?UserGroup $group;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $resource;

    /**
     * @param int $permissionId
     * @return $this
     */
    public function setPermissionId(int $permissionId): self
    {
        $this->permission_id = $permissionId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPermissionId(): ?int
    {
        return $this->permission_id;
    }

    /**
     * @return UserGroup|null
     */
    public function getGroup(): ?UserGroup
    {
        return $this->group;
    }

    /**
     * @param UserGroup $group
     * @return $this
     */
    public function setGroup(UserGroup $group): static
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @param string $resource
     * @return $this
     */
    public function setResource(string $resource): static
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getResource(): ?string
    {
        return $this->resource;
    }
}