<?php

namespace ProgramCms\WebsiteBundle\Entity;

use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteViewRepository::class)]
class WebsiteView
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $website_view_id = null;

    #[ORM\Column(length: 255)]
    private ?string $website_view_code = null;

    #[ORM\Column(length: 255)]
    private ?string $website_view_name = null;

    #[ORM\Column(length: 255)]
    private ?int $website_root_id = null;

    #[ORM\Column(length: 255)]
    private ?int $website_id = null;

    #[ORM\Column(length: 255)]
    private ?int $is_active = null;

    public function getWebsiteViewId(): ?int
    {
        return $this->website_view_id;
    }

    public function setWebsiteViewId(int $website_view_id): self
    {
        $this->website_view_id = $website_view_id;

        return $this;
    }

    public function getWebsiteViewCode(): ?int
    {
        return $this->website_view_code;
    }

    public function setWebsiteViewCode(int $website_view_code): self
    {
        $this->website_view_code = $website_view_code;

        return $this;
    }

    public function getWebsiteViewName(): ?int
    {
        return $this->website_view_name;
    }

    public function setWebsiteViewName(int $website_view_name): self
    {
        $this->website_view_name = $website_view_name;

        return $this;
    }

    public function getWebsiteRootId(): ?int
    {
        return $this->website_root_id;
    }

    public function setWebsiteRootId(int $website_root_id): self
    {
        $this->website_root_id = $website_root_id;

        return $this;
    }

    public function getWebsiteId(): ?int
    {
        return $this->website_id;
    }

    public function setWebsiteId(int $website_id): self
    {
        $this->website_id = $website_id;

        return $this;
    }

    public function getIsActive(): ?string
    {
        return $this->is_active;
    }

    public function setIsActive(string $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }
}
