<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Entity;

use ProgramCms\PostBundle\Repository\PostEntityDecimalRepository;
use Doctrine\ORM\Mapping as ORM;
use ProgramCms\WebsiteBundle\App\ScopedAttributeValue;

/**
 * Class PostEntityDecimal
 * @package ProgramCms\PostBundle\Entity
 */
#[ORM\Entity(repositoryClass: PostEntityDecimalRepository::class)]
class PostEntityDecimal extends ScopedAttributeValue
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