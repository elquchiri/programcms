<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity;

use ProgramCms\UserBundle\App\Eav\AbstractUserEntity;
use ProgramCms\UserBundle\Repository\UserEntityTextRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserEntityText
 * @package ProgramCms\UserBundle\Entity
 */
#[ORM\Entity(repositoryClass: UserEntityTextRepository::class)]
class UserEntityText extends AbstractUserEntity
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