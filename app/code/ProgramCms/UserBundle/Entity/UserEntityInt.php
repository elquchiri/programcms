<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity;

use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue;
use ProgramCms\UserBundle\Repository\UserEntityIntRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserEntityInt
 * @package ProgramCms\UserBundle\Entity
 */
#[ORM\Entity(repositoryClass: UserEntityIntRepository::class)]
class UserEntityInt extends AttributeValue
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