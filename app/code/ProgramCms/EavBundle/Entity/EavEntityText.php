<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Entity;

use ProgramCms\EavBundle\Repository\EavEntityTextRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EavEntityText
 * @package ProgramCms\EavBundle\Entity
 */
#[ORM\Entity(repositoryClass: EavEntityTextRepository::class)]
class EavEntityText extends \ProgramCms\EavBundle\Model\Attribute\AbstractEavEntity
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