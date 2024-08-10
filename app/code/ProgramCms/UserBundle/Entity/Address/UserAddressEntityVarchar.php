<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity\Address;

use ProgramCms\UserBundle\App\Eav\AbstractUserEntity;
use ProgramCms\UserBundle\Repository\UserEntityVarcharRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserAddressEntityVarchar
 * @package ProgramCms\UserBundle\Entity\Address
 */
#[ORM\Entity(repositoryClass: UserEntityVarcharRepository::class)]
class UserAddressEntityVarchar extends AbstractUserEntity
{
    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $value = null;

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        if(is_string($value) && !empty($value)) {
            $this->value = $value;
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}