<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Entity;

use ProgramCms\AdminBundle\Repository\AdminUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AdminUserRepository::class)]
class AdminUser extends \ProgramCms\CoreBundle\Model\Db\Entity\Entity implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $user_id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(nullable: true)]
    private ?int $is_active = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var array
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    /**
     * @var string|null
     */
    #[ORM\Column(nullable: true)]
    private ?string $first_name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(nullable: true)]
    private ?string $last_name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(nullable: true)]
    private ?string $interface_locale = null;

    /**
     * @param int $user_id
     * @return $this
     */
    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int $is_active
     * @return $this
     */
    public function setIsActive(int $is_active): static
    {
        $this->is_active = $is_active;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIsActive(): ?int
    {
        return $this->is_active;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $first_name
     * @return $this
     */
    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string $last_name
     * @return $this
     */
    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string $interface_locale
     * @return $this
     */
    public function setInterfaceLocale(string $interface_locale): static
    {
        $this->interface_locale = $interface_locale;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInterfaceLocale(): ?string
    {
        return $this->interface_locale;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_ADMIN';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }
}
