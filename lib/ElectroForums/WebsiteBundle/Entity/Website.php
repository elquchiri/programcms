<?php

namespace ElectroForums\WebsiteBundle\Entity;

use ElectroForums\WebsiteBundle\Repository\WebsiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteRepository::class)]
class Website
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $website_name = null;

    #[ORM\Column(length: 255)]
    private ?string $website_code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setEntityId(int $entity_id): self
    {
        $this->entity_id = $entity_id;

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

    public function getWebsiteCode(): ?string
    {
        return $this->website_code;
    }

    public function setWebsiteCode(string $website_code): self
    {
        $this->website_code = $website_code;

        return $this;
    }
}
