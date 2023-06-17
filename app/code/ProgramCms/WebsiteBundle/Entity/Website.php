<?php

namespace ProgramCms\WebsiteBundle\Entity;

use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteRepository::class)]
class Website
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $website_id = null;

    #[ORM\Column(length: 255)]
    private ?int $website_root_id = null;

    #[ORM\Column(length: 255)]
    private ?string $website_code = null;

    #[ORM\Column(length: 255)]
    private ?string $website_name = null;

    #[ORM\Column(length: 255)]
    private ?int $root_category_id = null;

    public function getWebsiteId(): ?int
    {
        return $this->website_id;
    }

    public function setWebsiteId(int $website_id): self
    {
        $this->website_id = $website_id;

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

    public function getWebsiteCode(): ?string
    {
        return $this->website_code;
    }

    public function setWebsiteCode(string $website_code): self
    {
        $this->website_code = $website_code;

        return $this;
    }

    public function getWebsiteName(): ?string
    {
        return $this->website_name;
    }

    public function setWebsiteName(string $website_name): self
    {
        $this->website_name = $website_name;

        return $this;
    }

    public function getRootCategoryId(): ?string
    {
        return $this->root_category_id;
    }

    public function setRootCategoryId(string $root_category_id): self
    {
        $this->root_category_id = $root_category_id;

        return $this;
    }
}
