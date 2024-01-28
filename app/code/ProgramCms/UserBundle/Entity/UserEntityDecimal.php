<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity;

use ProgramCms\UserBundle\Repository\UserEntityDecimalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserEntityDecimal
 * @package ProgramCms\UserBundle\Entity
 */
#[ORM\Entity(repositoryClass: UserEntityDecimalRepository::class)]
class UserEntityDecimal extends \ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue
{
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