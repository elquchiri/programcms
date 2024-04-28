<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Entity;

use ProgramCms\CatalogBundle\Repository\CategoryEntityTextRepository;
use ProgramCms\WebsiteBundle\App\ScopedAttributeValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CategoryEntityText
 * @package ProgramCms\CatalogBundle\Entity
 */
#[ORM\Entity(repositoryClass: CategoryEntityTextRepository::class)]
class CategoryEntityText extends ScopedAttributeValue
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