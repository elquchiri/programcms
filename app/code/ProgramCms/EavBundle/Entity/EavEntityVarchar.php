<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Entity;

use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue;
use ProgramCms\EavBundle\Repository\EavEntityVarcharRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EavEntityVarchar
 * @package ProgramCms\EavBundle\Entity
 */
#[ORM\Entity(repositoryClass: EavEntityVarcharRepository::class)]
class EavEntityVarchar extends AttributeValue
{

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