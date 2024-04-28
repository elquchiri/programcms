<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Entity;

use DateTime;
use ProgramCms\WebsiteBundle\App\ScopedAttributeValue;
use ProgramCms\PostBundle\Repository\PostEntityDatetimeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostEntityDatetime
 * @package ProgramCms\PostBundle\Entity
 */
#[ORM\Entity(repositoryClass: PostEntityDatetimeRepository::class)]
class PostEntityDatetime extends ScopedAttributeValue
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