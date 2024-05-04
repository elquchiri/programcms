<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CatalogBundle\App\Eav\CategoryEntityValue;
use ProgramCms\CatalogBundle\Repository\CategoryEntityIntRepository;

/**
 * Class CategoryEntityInt
 * @package ProgramCms\CatalogBundle\Entity
 */
#[ORM\Entity(repositoryClass: CategoryEntityIntRepository::class)]
class CategoryEntityInt extends CategoryEntityValue
{
    /**
     * @var int|null
     */
    #[ORM\Column(nullable: true)]
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