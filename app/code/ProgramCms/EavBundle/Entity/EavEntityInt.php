<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Entity;

use ProgramCms\EavBundle\Repository\EavEntityIntRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EavEntityInt
 * @package ProgramCms\EavBundle\Entity
 */
#[ORM\Entity(repositoryClass: EavEntityIntRepository::class)]
class EavEntityInt extends \ProgramCms\EavBundle\Model\Attribute\AbstractEavEntity
{
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