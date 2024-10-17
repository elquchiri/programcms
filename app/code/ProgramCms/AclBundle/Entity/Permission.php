<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Entity;

use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\AclBundle\Repository\PermissionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Permission
 * @package ProgramCms\AclBundle\Entity
 */
#[ORM\Entity(repositoryClass: PermissionRepository::class)]
class Permission extends AbstractEntity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $permission_id = null;

    /**
     * @var Role|null
     */
    #[ORM\ManyToOne(targetEntity: Role::class)]
    #[ORM\JoinColumn(name: 'role_id', referencedColumnName: 'role_id')]
    private ?Role $role;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $resource;

    /**
     * @param int $permissionId
     * @return $this
     */
    public function setPermissionId(int $permissionId): static
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
     * @param Role $role
     * @return $this
     */
    public function setRole(Role $role): static
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return Role|null
     */
    public function getRole(): ?Role
    {
        return $this->role;
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