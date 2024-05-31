<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Entity;

use ProgramCms\PostBundle\App\Eav\AbstractPostEntity;
use ProgramCms\PostBundle\Repository\PostEntityVarcharRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostEntityVarchar
 * @package ProgramCms\PostBundle\Entity
 */
#[ORM\Entity(repositoryClass: PostEntityVarcharRepository::class)]
class PostEntityVarchar extends AbstractPostEntity
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