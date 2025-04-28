<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity\Group;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\Group\UserGroupRepository;

/**
 * Class UserGroup
 * @package ProgramCms\UserBundle\Entity\Group
 */
#[ORM\Entity(repositoryClass: UserGroupRepository::class)]
class UserGroup extends AbstractEntity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $group_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $code;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $name;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $color;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'group', targetEntity: UserGroupPermission::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $permissions;

    /**
     * @var Collection
     */
    #[ORM\JoinTable(name: 'user_group_relation')]
    #[ORM\ManyToMany(targetEntity: UserEntity::class, inversedBy: 'groups')]
    #[ORM\JoinColumn(name: 'group_id', referencedColumnName: 'group_id')]
    #[ORM\InverseJoinColumn(name: 'user_id', referencedColumnName: 'entity_id')]
    protected Collection $users;

    /**
     * UserGroup constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->users = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    /**
     * @param int $groupId
     * @return $this
     */
    public function setGroupId(int $groupId): self
    {
        $this->group_id = $groupId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getGroupId(): ?int
    {
        return $this->group_id;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): static
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;
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
     * @return string|null
     */
    public function getColor(): ?string
    {
        return !empty($this->color) ? $this->color : '#888';
    }

    /**
     * @param string $color
     * @return $this
     */
    public function setColor(string $color): static
    {
        $this->color = $color;
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
                $permission = new UserGroupPermission();
                $permission->setResource($acl);
                $permission->setGroup($this);
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
     * @param UserGroupPermission $permission
     * @return $this
     */
    public function addPermission(UserGroupPermission $permission): static
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions[] = $permission;
            $permission->setGroup($this);
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
     * @param UserEntity $user
     * @return $this
     */
    public function addUser(UserEntity $user): static
    {
        if(!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addGroup($this);
        }
        return $this;
    }

    /**
     * @param UserEntity $user
     */
    public function removeUser(UserEntity $user)
    {
        $this->users->removeElement($user);
    }
}