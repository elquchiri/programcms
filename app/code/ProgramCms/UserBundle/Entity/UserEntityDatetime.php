<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity;

use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue;
use ProgramCms\UserBundle\Repository\UserEntityDatetimeRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserEntityDatetime
 * @package ProgramCms\UserBundle\Entity
 */
#[ORM\Entity(repositoryClass: UserEntityDatetimeRepository::class)]
class UserEntityDatetime extends AttributeValue
{
    /**
     * @var DateTime|null
     */
    #[ORM\Column(type: 'datetime')]
    private ?DateTime $value = null;

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        if($value instanceof DateTime) {
            $this->value = $value;
        }

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getValue(): ?DateTime
    {
        return $this->value;
    }
}