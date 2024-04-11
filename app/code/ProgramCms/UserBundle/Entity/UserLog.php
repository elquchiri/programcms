<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use ProgramCms\UserBundle\Repository\UserLogRepository;

/**
 * Class UserLog
 * @package ProgramCms\UserBundle\Entity
 */
#[ORM\Entity(repositoryClass: UserLogRepository::class)]
class UserLog extends Entity
{
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
}
