<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CatalogBundle\Repository\CategoryEntityIntRepository;
use ProgramCms\WebsiteBundle\App\ScopedAttributeValue;

/**
 * Class CategoryEntityInt
 * @package ProgramCms\CatalogBundle\Entity
 */
#[ORM\Entity(repositoryClass: CategoryEntityIntRepository::class)]
class CategoryEntityInt extends ScopedAttributeValue
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