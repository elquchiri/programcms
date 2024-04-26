<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ProgramCms\EavBundle\Model\Entity\Entity;
use ProgramCms\UserBundle\Entity\Address\UserAddressEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Unique;
use Doctrine\Common\Collections\Collection;

/**
 * Class User
 * @package ProgramCms\UserBundle\Entity
 */
#[ORM\Entity(repositoryClass: UserEntityRepository::class)]
class UserEntity extends Entity implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var WebsiteView|null
     */
    #[ORM\ManyToOne(targetEntity: WebsiteView::class)]
    #[ORM\JoinColumn(name: 'website_view_id', referencedColumnName: 'website_view_id')]
    private ?WebsiteView $websiteView;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Unique]
    private ?string $email = null;

    /**
     * @var array
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $password;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $user_firstname = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $user_lastname = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Unique]
    private ?string $username = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $reset_token;

    /**
     * @var bool|null
     */
    #[ORM\Column(nullable: true, options: ['default' => 0])]
    private ?bool $account_lock;

    /**
     * @var bool|null
     */
    #[ORM\Column(nullable: true, options: ['default' => 0])]
    private ?bool $confirmed_email;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserLog::class)]
    private Collection $logs;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserAddressEntity::class)]
    private Collection $addresses;

    /**
     * UserEntity constructor.
     * @param array $data
     */
    public function __construct(
        array $data = []
    )
    {
        parent::__construct($data);
        $this->logs = new ArrayCollection();
        $this->addresses = new ArrayCollection();
    }

    /**
     * @param WebsiteView $websiteView
     * @return $this
     */
    public function setWebsiteView(WebsiteView $websiteView): static
    {
        $this->websiteView = $websiteView;
        return $this;
    }

    /**
     * @return WebsiteView
     */
    public function getWebsiteView(): WebsiteView
    {
        return $this->websiteView;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroups(): string
    {
        return implode(',', $this->getRoles());
    }

    /**
     * @param string $groups
     * @return $this
     */
    public function setGroups(string $groups): static
    {
        $this->roles = explode(',', $groups);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserFirstname(): ?string
    {
        return $this->user_firstname;
    }

    /**
     * @param string $user_firstname
     * @return $this
     */
    public function setUserFirstname(string $user_firstname): self
    {
        $this->user_firstname = $user_firstname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserLastname(): ?string
    {
        return $this->user_lastname;
    }

    /**
     * @param string $user_lastname
     * @return $this
     */
    public function setUserLastname(string $user_lastname): self
    {
        $this->user_lastname = $user_lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->getUserFirstname() . ' ' . $this->getUserLastname();
    }

    /**
     * @return string|null
     */
    public function getUserName(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUserName(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials() {}

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @return string|null
     */
    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    /**
     * @param string|null $resetToken
     * @return $this
     */
    public function setResetToken(?string $resetToken): static
    {
        $this->reset_token = $resetToken;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAccountLock(): ?bool
    {
        return $this->account_lock;
    }

    /**
     * @param mixed $accountLock
     * @return $this
     */
    public function setAccountLock(mixed $accountLock): static
    {
        $this->account_lock = (bool)$accountLock;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLocked(): bool
    {
        return $this->account_lock ?: false;
    }

    /**
     * @return bool
     */
    public function isUnlocked(): bool
    {
        return !($this->account_lock ?: false);
    }

    /**
     * @return bool|null
     */
    public function getConfirmedEmail(): ?bool
    {
        return $this->confirmed_email;
    }

    /**
     * @param bool $confirmedEmail
     * @return $this
     */
    public function setConfirmedEmail(bool $confirmedEmail): static
    {
        $this->confirmed_email = $confirmedEmail;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEmailConfirmed(): bool
    {
        return $this->confirmed_email ?: false;
    }

    /**
     * @return Collection
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    /**
     * @param UserLog $log
     * @return $this
     */
    public function addLog(UserLog $log): static
    {
        if(!$this->logs->contains($log)) {
            $this->logs[] = $log;
        }
        return $this;
    }

    /**
     * Clear all user logs
     * More attention calling this method.
     * @return $this
     */
    public function clearLogs(): static
    {
        $this->logs->clear();
        return $this;
    }

    /**
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param UserAddressEntity $userAddressEntity
     * @return $this
     */
    public function addAddress(UserAddressEntity $userAddressEntity): static
    {
        if(!$this->addresses->contains($userAddressEntity)) {
            $this->addresses[] = $userAddressEntity;
        }
        return $this;
    }

    /**
     * @param UserAddressEntity $userAddressEntity
     * @return $this
     */
    public function removeAddress(UserAddressEntity $userAddressEntity): static
    {
        $this->addresses->removeElement($userAddressEntity);
        return $this;
    }
}
