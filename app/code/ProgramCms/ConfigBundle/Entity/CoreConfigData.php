<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Entity;

use ProgramCms\ConfigBundle\Repository\CoreConfigDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CoreConfigData
 * @package ProgramCms\ConfigBundle\Entity
 */
#[ORM\Entity(repositoryClass: CoreConfigDataRepository::class)]
class CoreConfigData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $config_id = null;

    #[ORM\Column(length: 255)]
    private ?string $scope = null;

    #[ORM\Column]
    private ?int $scope_id = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    public function getConfigId(): ?int
    {
        return $this->config_id;
    }

    public function setConfigId(int $config_id): self
    {
        $this->config_id = $config_id;

        return $this;
    }

    public function getScope(): ?string
    {
        return $this->scope;
    }

    public function setScope(string $scope): self
    {
        $this->scope = $scope;

        return $this;
    }

    public function getScopeId(): ?int
    {
        return $this->scope_id;
    }

    public function setScopeId(string $scope_id): self
    {
        $this->scope_id = $scope_id;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
