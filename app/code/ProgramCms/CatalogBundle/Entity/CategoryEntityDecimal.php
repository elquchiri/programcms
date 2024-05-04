<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Entity;

use ProgramCms\CatalogBundle\App\Eav\CategoryEntityValue;
use ProgramCms\CatalogBundle\Repository\CategoryEntityDecimalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CategoryEntityDecimal
 * @package ProgramCms\CatalogBundle\Entity
 */
#[ORM\Entity(repositoryClass: CategoryEntityDecimalRepository::class)]
class CategoryEntityDecimal extends CategoryEntityValue
{
    /**
     * @var float|null
     */
    #[ORM\Column(length: 255)]
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