<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\PostBundle\App\Eav\AbstractPostEntity;
use ProgramCms\PostBundle\Repository\PostEntityIntRepository;

/**
 * Class PostEntityInt
 * @package ProgramCms\PostBundle\Entity
 */
#[ORM\Entity(repositoryClass: PostEntityIntRepository::class)]
class PostEntityInt extends AbstractPostEntity
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