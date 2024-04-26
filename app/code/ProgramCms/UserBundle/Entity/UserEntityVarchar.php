<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity;

use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue;
use ProgramCms\UserBundle\Repository\UserEntityVarcharRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserEntityVarchar
 * @package ProgramCms\UserBundle\Entity
 */
#[ORM\Entity(repositoryClass: UserEntityVarcharRepository::class)]
class UserEntityVarchar extends AttributeValue
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