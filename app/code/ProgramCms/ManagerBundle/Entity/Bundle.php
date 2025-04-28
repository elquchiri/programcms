<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ManagerBundle\Entity;

use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Bundle
 * @package ProgramCms\ManagerBundle\Entity
 */
class Bundle extends Entity
{
    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $bundle_name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $bundle_path = null;

    #[ORM\Column(nullable: true, options: ['default' => 0])]
    private ?bool $status;

    /**
     * @param $bundle_name
     * @return $this
     */
    public function setBundleName($bundle_name): static
    {
        $this->bundle_name = $bundle_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBundleName(): ?string
    {
        return $this->bundle_name;
    }

    /**
     * @param string $bundle_path
     * @return $this
     */
    public function setBundlePath(string $bundle_path): static
    {
        $this->bundle_path = $bundle_path;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBundlePath(): ?string
    {
        return $this->bundle_path;
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

    /**
     * @return bool|null
     */
    public function getStatus(): ?bool
    {
        return $this->status;
    }
}