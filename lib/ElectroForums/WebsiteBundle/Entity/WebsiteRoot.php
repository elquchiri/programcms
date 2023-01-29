<?php

namespace ElectroForums\WebsiteBundle\Entity;

use ElectroForums\WebsiteBundle\Repository\WebsiteRootRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteRootRepository::class)]
class WebsiteRoot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $website_root_id = null;

    #[ORM\Column(length: 255)]
    private ?string $website_root_name = null;

    #[ORM\Column(length: 255)]
    private ?string $website_root_code = null;

    #[ORM\Column(length: 255)]
    private ?int $is_default = null;

    public function getWebsiteRootId(): ?int
    {
        return $this->website_root_id;
    }

    public function setWebsiteRootId(int $website_root_id): self
    {
        $this->website_root_id = $website_root_id;

        return $this;
    }

    public function getWebsiteRootName(): ?string
    {
        return $this->website_root_name;
    }

    public function setWebsiteRootName(string $website_root_name): self
    {
        $this->website_root_name = $website_root_name;

        return $this;
    }

    public function getWebsiteRootCode(): ?string
    {
        return $this->website_root_code;
    }

    public function setWebsiteRootCode(string $website_root_code): self
    {
        $this->website_root_code = $website_root_code;

        return $this;
    }

    public function getIsDefault(): ?string
    {
        return $this->is_default;
    }

    public function setIsDefault(string $is_default): self
    {
        $this->is_default = $is_default;

        return $this;
    }
}
