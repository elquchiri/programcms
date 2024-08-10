<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity\Address;

use ProgramCms\UserBundle\App\Eav\AbstractUserEntity;
use ProgramCms\UserBundle\Repository\UserEntityDecimalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserAddressEntityDecimal
 * @package ProgramCms\UserBundle\Entity\Address
 */
#[ORM\Entity(repositoryClass: UserEntityDecimalRepository::class)]
class UserAddressEntityDecimal extends AbstractUserEntity
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