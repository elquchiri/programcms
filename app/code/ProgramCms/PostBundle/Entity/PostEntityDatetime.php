<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Entity;

use DateTime;
use ProgramCms\PostBundle\App\Eav\AbstractPostEntity;
use ProgramCms\PostBundle\Repository\PostEntityDatetimeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostEntityDatetime
 * @package ProgramCms\PostBundle\Entity
 */
#[ORM\Entity(repositoryClass: PostEntityDatetimeRepository::class)]
class PostEntityDatetime extends AbstractPostEntity
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