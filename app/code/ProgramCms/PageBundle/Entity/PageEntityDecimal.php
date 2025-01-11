<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Entity;

use ProgramCms\PageBundle\App\Eav\AbstractPageEntity;
use ProgramCms\PageBundle\Repository\PageEntityDecimalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PageEntityDecimal
 * @package ProgramCms\PageBundle\Entity
 */
#[ORM\Entity(repositoryClass: PageEntityDecimalRepository::class)]
class PageEntityDecimal extends AbstractPageEntity
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