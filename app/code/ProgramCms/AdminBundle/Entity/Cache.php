<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\AdminBundle\Repository\CacheRepository;
use ProgramCms\CoreBundle\Model\Db\Entity\Entity;

/**
 * Class Cache
 * @package ProgramCms\AdminBundle\Entity
 */
#[ORM\Entity(repositoryClass: CacheRepository::class)]
class Cache extends Entity
{
    /**
     * @var int|null
     */
    #[ORM\Column(nullable: false)]
    private ?string $cache_tag = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $cache_type = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?bool $status = null;

    /**
     * @return string|null
     */
    public function getCacheTag(): ?string
    {
        return $this->cache_tag;
    }

    /**
     * @param string $cacheTag
     * @return $this
     */
    public function setCacheTag(string $cacheTag): static
    {
        $this->cache_tag = $cacheTag;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCacheType(): ?string
    {
        return $this->cache_type;
    }

    /**
     * @param string $cacheType
     * @return $this
     */
    public function setCacheType(string $cacheType): static
    {
        $this->cache_type = $cacheType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getStatus(): ?bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function setStatus(bool $status): static
    {
        $this->status = $status;
        return $this;
    }
}
