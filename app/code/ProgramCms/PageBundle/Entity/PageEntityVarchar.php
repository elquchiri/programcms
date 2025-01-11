<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Entity;

use ProgramCms\PageBundle\App\Eav\AbstractPageEntity;
use ProgramCms\PageBundle\Repository\PageEntityVarcharRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PageEntityVarchar
 * @package ProgramCms\PageBundle\Entity
 */
#[ORM\Entity(repositoryClass: PageEntityVarcharRepository::class)]
class PageEntityVarchar extends AbstractPageEntity
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