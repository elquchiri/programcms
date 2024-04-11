<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity\Address;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\EavBundle\Model\Entity\Entity;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\Address\UserAddressEntityRepository;

/**
 * Class UserAddressEntity
 * @package ProgramCms\UserBundle\Entity\Address
 */
#[ORM\Entity(repositoryClass: UserAddressEntityRepository::class)]
class UserAddressEntity extends Entity
{
    /**
     * @var UserEntity|null
     */
    #[ORM\ManyToOne(targetEntity: UserEntity::class, inversedBy: 'labels')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'entity_id')]
    private ?UserEntity $user;

    /**
     * @var bool|null
     */
    #[ORM\Column(type: 'integer')]
    private ?bool $is_active;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $city;

    /**
     * @var int|null
     */
    #[ORM\Column(type: 'integer')]
    private ?int $country_id;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $fax;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $first_name;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $last_name;

    /**
     * @var int|null
     */
    #[ORM\Column(type: 'integer', length: 50)]
    private ?int $postcode;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 100)]
    private ?string $region;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 200)]
    private ?string $street;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 25)]
    private ?string $telephone;

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
}
