<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ProgramCms\AclBundle\Repository\RoleRepository;
use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Class Role
 * @package ProgramCms\AclBundle\Entity
 */
#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[UniqueEntity('role_code')]
class Role extends AbstractEntity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $role_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $role_name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 100, unique: true)]
    private ?string $role_code = null;

    /**
     * @var AdminUser|null
     */
    #[ORM\ManyToOne(targetEntity: AdminUser::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'user_id')]
    private ?AdminUser $user;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    /**
     * @var Collection
     */
    #[ORM\JoinTable(name: 'admin_user_role_relation')]
    #[ORM\ManyToMany(targetEntity: AdminUser::class, inversedBy: 'roles')]
    #[ORM\JoinColumn(name: 'role_id', referencedColumnName: 'role_id')]
    #[ORM\InverseJoinColumn(name: 'user_id', referencedColumnName: 'user_id')]
    protected Collection $users;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'role', targetEntity: Permission::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $permissions;

    /**
     * Role constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->users = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getRoleId(): ?int
    {
        return $this->role_id;
    }

    /**
     * @param int $roleId
     * @return $this
     */
    public function setRoleId(int $roleId): static
    {
        $this->role_id = $roleId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRoleName(): ?string
    {
        return $this->role_name;
    }

    /**
     * @param string $roleName
     * @return $this
     */
    public function setRoleName(string $roleName): static
    {
        $this->role_name = $roleName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRoleCode(): ?string
    {
        return $this->role_code;
    }

    /**
     * @param string $roleCode
     * @return $this
     */
    public function setRoleCode(string $roleCode): static
    {
        $this->role_code = $roleCode;
        return $this;
    }

    /**
     * @return AdminUser
     */
    public function getUser(): AdminUser
    {
        return $this->user;
    }

    /**
     * @param AdminUser $user
     * @return $this
     */
    public function setUser(AdminUser $user): static
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param mixed $permissions
     * @return $this
     */
    public function setPermissions(mixed $permissions): static
    {
        $this->permissions = new ArrayCollection();
        foreach ($permissions as $permission) {
            if(is_string($permission)) {
                $acl = $permission;
                $permission = new Permission();
                $permission->setResource($acl);
                $permission->setRole($this);
            }
            $this->addPermission($permission);
        }
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getPermissions(): ?Collection
    {
        return $this->permissions;
    }

    /**
     * @param Permission $permission
     * @return $this
     */
    public function addPermission(Permission $permission): static
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions[] = $permission;
            $permission->setRole($this);
        }

        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getUsers(): ?Collection
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection $users
     * @return $this
     */
    public function setUsers(ArrayCollection $users): static
    {
        $this->cleanUsers();

        foreach($users as $user) {
            $this->addUser($user);
        }
        return $this;
    }

    public function cleanUsers()
    {
        foreach($this->users as $user) {
            $this->removeUser($user);
        }
    }

    /**
     * @param AdminUser $user
     * @return $this
     */
    public function addUser(AdminUser $user): static
    {
        if(!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addRole($this);
        }
        return $this;
    }

    /**
     * @param AdminUser $user
     */
    public function removeUser(AdminUser $user)
    {
        $this->users->removeElement($user);
    }
}