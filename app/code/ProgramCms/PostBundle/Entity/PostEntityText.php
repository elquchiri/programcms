<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Entity;

use ProgramCms\PostBundle\App\Eav\AbstractPostEntity;
use ProgramCms\PostBundle\Repository\PostEntityTextRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostEntityText
 * @package ProgramCms\PostBundle\Entity
 */
#[ORM\Entity(repositoryClass: PostEntityTextRepository::class)]
class PostEntityText extends AbstractPostEntity
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