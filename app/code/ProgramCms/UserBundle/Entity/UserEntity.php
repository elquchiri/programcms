<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package ProgramCms\UserBundle\Entity
 */
#[ORM\Entity(repositoryClass: UserEntityRepository::class)]
class UserEntity extends \ProgramCms\EavBundle\Model\Entity\Entity implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(length: 255)]
    private ?string $user_firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $user_lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $user_nickname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private string $password;

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
    public function getUserNickname(): ?string
    {
        return $this->user_nickname;
    }

    /**
     * @param string $user_nickname
     * @return $this
     */
    public function setUserNickname(string $user_nickname): self
    {
        $this->user_nickname = $user_nickname;
        return $this;
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

    public function eraseCredentials() {}

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}
