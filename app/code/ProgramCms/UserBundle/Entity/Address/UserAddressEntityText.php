<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity\Address;

use ProgramCms\UserBundle\App\Eav\AbstractUserAddressEntity;
use ProgramCms\UserBundle\Repository\Address\UserAddressEntityTextRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserAddressEntityText
 * @package ProgramCms\UserBundle\Entity\Address
 */
#[ORM\Entity(repositoryClass: UserAddressEntityTextRepository::class)]
class UserAddressEntityText extends AbstractUserAddressEntity
{
    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text')]
    private ?string $value = null;

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        if(is_string($value)) {
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