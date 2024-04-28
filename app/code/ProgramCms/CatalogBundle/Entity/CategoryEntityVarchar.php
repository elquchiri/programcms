<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Entity;

use ProgramCms\CatalogBundle\Repository\CategoryEntityVarcharRepository;
use ProgramCms\WebsiteBundle\App\ScopedAttributeValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CategoryEntityVarchar
 * @package ProgramCms\CatalogBundle\Entity
 */
#[ORM\Entity(repositoryClass: CategoryEntityVarcharRepository::class)]
class CategoryEntityVarchar extends ScopedAttributeValue
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