<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\EavBundle\Model\Entity\Attribute\AdditionalEavAttribute;
use ProgramCms\UserBundle\Repository\UserEavAttributeRepository;

/**
 * Class UserEavAttribute
 * @package ProgramCms\UserBundle\Entity
 */
#[ORM\Entity(repositoryClass: UserEavAttributeRepository::class)]
class UserEavAttribute extends AdditionalEavAttribute
{
    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $is_visible = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $sort_order = null;

    /**
     * @param int $is_visible
     * @return $this
     */
    public function setIsVisible(int $is_visible): static
    {
        $this->is_visible = $is_visible;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIsVisible(): ?int
    {
        return $this->is_visible;
    }

    /**
     * @param int $sort_order
     * @return $this
     */
    public function setSortOrder(int $sort_order): static
    {
        $this->sort_order = $sort_order;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSortOrder(): ?int
    {
        return $this->sort_order;
    }
}