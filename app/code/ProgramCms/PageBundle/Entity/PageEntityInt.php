<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\PageBundle\App\Eav\AbstractPageEntity;
use ProgramCms\PageBundle\Repository\PageEntityIntRepository;

/**
 * Class PageEntityInt
 * @package ProgramCms\PageBundle\Entity
 */
#[ORM\Entity(repositoryClass: PageEntityIntRepository::class)]
class PageEntityInt extends AbstractPageEntity
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