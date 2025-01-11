<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Entity;

use DateTime;
use ProgramCms\PageBundle\App\Eav\AbstractPageEntity;
use ProgramCms\PageBundle\Repository\PageEntityDatetimeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PageEntityDatetime
 * @package ProgramCms\PageBundle\Entity
 */
#[ORM\Entity(repositoryClass: PageEntityDatetimeRepository::class)]
class PageEntityDatetime extends AbstractPageEntity
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