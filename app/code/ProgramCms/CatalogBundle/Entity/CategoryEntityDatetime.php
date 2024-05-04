<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Entity;

use DateTime;
use ProgramCms\CatalogBundle\App\Eav\CategoryEntityValue;
use ProgramCms\CatalogBundle\Repository\CategoryEntityDatetimeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CategoryEntityDatetime
 * @package ProgramCms\CatalogBundle\Entity
 */
#[ORM\Entity(repositoryClass: CategoryEntityDatetimeRepository::class)]
class CategoryEntityDatetime extends CategoryEntityValue
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