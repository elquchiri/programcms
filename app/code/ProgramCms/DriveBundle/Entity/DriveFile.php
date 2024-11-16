<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DriveBundle\Entity;

use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use ProgramCms\DriveBundle\Repository\DriveFileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DriveFile
 * @package ProgramCms\DriveBundle\Entity
 */
#[ORM\Entity(repositoryClass: DriveFileRepository::class)]
class DriveFile extends Entity
{
    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $name;

    /**
     * @var int
     */
    #[ORM\Column(type: 'integer')]
    private int $size;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $extension;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $type;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $mime_type;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $path;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $generated_name;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    /**
     * @var array|null
     */
    #[ORM\Column(type: 'json')]
    private ?array $perms;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return $this
     */
    public function setExtension(string $extension): self
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    /**
     * @return string
     */
    public function getShortMimeType(): string
    {
        $mime = $this->getMimeType();
        $exp = explode('/', $mime);
        return $exp[0] === 'application' ? 'file' : $exp[0];
    }

    /**
     * @param string $mime_type
     * @return $this
     */
    public function setMimeType(string $mime_type): self
    {
        $this->mime_type = $mime_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getGeneratedName(): string
    {
        return $this->generated_name;
    }

    /**
     * @param string $generated_name
     * @return $this
     */
    public function setGeneratedName(string $generated_name): self
    {
        $this->generated_name = $generated_name;
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
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param array $perms
     * @return $this
     */
    public function setPerms(array $perms): self
    {
        $this->perms = $perms;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getPerms(): ?array
    {
        return $this->perms;
    }
}