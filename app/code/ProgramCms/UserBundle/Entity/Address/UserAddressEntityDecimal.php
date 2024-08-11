<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity\Address;

use ProgramCms\UserBundle\App\Eav\AbstractUserAddressEntity;
use ProgramCms\UserBundle\Repository\Address\UserAddressEntityDecimalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserAddressEntityDecimal
 * @package ProgramCms\UserBundle\Entity\Address
 */
#[ORM\Entity(repositoryClass: UserAddressEntityDecimalRepository::class)]
class UserAddressEntityDecimal extends AbstractUserAddressEntity
{
    /**
     * @var float|null
     */
    #[ORM\Column]
    private ?float $value = null;

    /**
     * @param float $value
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        if(is_float($value) && !empty($value)) {
            $this->value = $value;
        }

        return $this;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }
}