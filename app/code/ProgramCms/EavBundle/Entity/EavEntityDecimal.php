<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Entity;

use ProgramCms\EavBundle\Repository\EavEntityDecimalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EavEntityDecimal
 * @package ProgramCms\EavBundle\Entity
 */
#[ORM\Entity(repositoryClass: EavEntityDecimalRepository::class)]
class EavEntityDecimal extends \ProgramCms\EavBundle\Model\Attribute\AbstractEavEntity
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