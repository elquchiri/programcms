<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JetBrains\PhpStorm\Pure;
use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use ProgramCms\CoreBundle\View\Design\ThemeInterface;
use ProgramCms\ThemeBundle\Repository\ThemeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme extends Entity implements ThemeInterface
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $theme_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(nullable: true)]
    private ?string $area = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Theme::class)]
    protected Collection $children;

    /**
     * @var Theme|null
     */
    #[ORM\ManyToOne(targetEntity: Theme::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'theme_id', nullable: true)]
    protected ?Theme $parent = null;

    /**
     * @var string|null
     */
    #[ORM\Column(nullable: true)]
    private ?string $theme_title = null;

    /**
     * @var string|null
     */
    #[ORM\Column]
    private ?string $theme_path = null;

    /**
     * @var string|null
     */
    #[ORM\Column(nullable: true)]
    private ?string $preview_image;

    /**
     * Theme constructor.
     * @param array $data
     */
    public function __construct(
        array $data = []
    )
    {
        $this->children = new ArrayCollection();
        parent::__construct($data);
    }

    /**
     * @return int|null
     */
    public function getThemeId(): ?int
    {
        return $this->theme_id;
    }

    /**
     * @param int $theme_id
     * @return $this
     */
    public function setThemeId(int $theme_id): self
    {
        $this->theme_id = $theme_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getArea(): ?string
    {
        return $this->area;
    }

    /**
     * @param string $area
     * @return $this
     */
    public function setArea(string $area): static
    {
        $this->area = $area;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return Theme|null
     */
    public function getParent(): ?Theme
    {
        return $this->parent;
    }

    /**
     * @param Theme $parent
     * @return $this
     */
    public function setParent(Theme $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return string
     */
    #[Pure] public function getParentThemeTitle(): string
    {
        return $this->hasParent() ? $this->parent->getThemeTitle() : '';
    }

    public function hasParent()
    {
        return isset($this->parent);
    }

    /**
     * @return string|null
     */
    public function getThemeTitle(): ?string
    {
        return $this->theme_title;
    }

    /**
     * @param string $theme_title
     * @return $this
     */
    public function setThemeTitle(string $theme_title): static
    {
        $this->theme_title = $theme_title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getThemePath(): ?string
    {
        return $this->theme_path;
    }

    /**
     * @param string $theme_path
     * @return $this
     */
    public function setThemePath(string $theme_path): static
    {
        $this->theme_path = $theme_path;
        return $this;
    }

    /**
     * @param string $preview_image
     * @return $this
     */
    public function setPreviewImage(string $preview_image): static
    {
        $this->preview_image = $preview_image;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPreviewImage(): ?string
    {
        return $this->preview_image;
    }
}
