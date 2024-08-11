<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity\Address;

use ProgramCms\UserBundle\App\Eav\AbstractUserAddressEntity;
use ProgramCms\UserBundle\Repository\Address\UserAddressEntityIntRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserAddressEntityInt
 * @package ProgramCms\UserBundle\Entity\Address
 */
#[ORM\Entity(repositoryClass: UserAddressEntityIntRepository::class)]
class UserAddressEntityInt extends AbstractUserAddressEntity
{
    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $value = null;

    /**
     * @param int $value
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        if(is_int($value)) {
            $this->value = $value;
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }
}