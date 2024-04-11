<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Entity;

use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CoreBundle\Model\Db\Entity\Entity;

/**
 * Class Category
 * @package ProgramCms\CatalogBundle\Entity
 */
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category extends Entity
{
    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $attribute_set_id = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $parent = null;

    /**
     * @return string|null
     */
    public function getParent(): ?string
    {
        return $this->parent;
    }

    /**
     * @param string $parent
     * @return $this
     */
    public function setParent(string $parent): self
    {
        $this->parent = $parent;
        return $this;
    }
}
