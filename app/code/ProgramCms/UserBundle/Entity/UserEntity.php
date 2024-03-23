<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\EavBundle\Model\Entity\Entity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Unique;

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
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $reset_token;

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
}
