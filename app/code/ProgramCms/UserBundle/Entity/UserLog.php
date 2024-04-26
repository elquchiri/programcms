<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\UserBundle\Repository\UserLogRepository;

/**
 * Class UserLog
 * @package ProgramCms\UserBundle\Entity
 */
#[ORM\Entity(repositoryClass: UserLogRepository::class)]
class UserLog extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $entity_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $ip_address;

    /**
     * @var UserEntity|null
     */
    #[ORM\ManyToOne(targetEntity: UserEntity::class, inversedBy: 'logs')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'entity_id')]
    private ?UserEntity $user;

    /**
     * @var DateTime|null
     */
    #[ORM\Column(type: 'datetime')]
    protected ?DateTime $created_at = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    protected ?string $device;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    protected ?string $os;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    protected ?string $browser;

    /**
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->entity_id;
    }

    /**
     * @param int $entityId
     * @return $this
     */
    public function setEntityId(int $entityId): static
    {
        $this->entity_id = $entityId;
        return $this;
    }

    /**
     * @return UserEntity|null
     */
    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    /**
     * @param UserEntity $userEntity
     * @return $this
     */
    public function setUser(UserEntity $userEntity): static
    {
        $this->user = $userEntity;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->ip_address;
    }

    /**
     * @param string $ip
     * @return $this
     */
    public function setIpAddress(string $ip): static
    {
        $this->ip_address = $ip;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt): static
    {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDevice(): ?string
    {
        return $this->device;
    }

    /**
     * @param string $device
     * @return $this
     */
    public function setDevice(string $device): static
    {
        $this->device = $device;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOs(): ?string
    {
        return $this->os;
    }

    /**
     * @param string $os
     * @return $this
     */
    public function setOs(string $os): static
    {
        $this->os = $os;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    /**
     * @param string $browser
     * @return $this
     */
    public function setBrowser(string $browser): static
    {
        $this->browser = $browser;
        return $this;
    }
}
