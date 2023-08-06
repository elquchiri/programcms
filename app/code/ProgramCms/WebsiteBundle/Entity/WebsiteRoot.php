<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Entity;

use Doctrine\Common\Collections\Collection;
use ProgramCms\WebsiteBundle\Repository\WebsiteRootRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteRootRepository::class)]
class WebsiteRoot extends \ProgramCms\CoreBundle\Model\Db\Entity\Entity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $website_root_id = null;
    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?string $is_active = null;
    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $website_root_name = null;
    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $website_root_code = null;
    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $sort_order = null;
    /**
     * @var Website|null
     */
    #[ORM\ManyToOne(targetEntity: Website::class)]
    #[ORM\JoinColumn(name: 'default_website_id', referencedColumnName: 'website_id')]
    private ?Website $defaultWebsite;
    /**
     * @var int|null
     */
    #[ORM\Column(nullable: true)]
    private ?int $is_default = null;
    /**
     * @var Collection|null
     */
    #[ORM\OneToMany(mappedBy: 'websiteRoot', targetEntity: Website::class)]
    private ?Collection $websites = null;

    /**
     * @return int|null
     */
    public function getWebsiteRootId(): ?int
    {
        return $this->website_root_id;
    }

    /**
     * @param int $website_root_id
     * @return $this
     */
    public function setWebsiteRootId(int $website_root_id): self
    {
        $this->website_root_id = $website_root_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIsActive(): ?string
    {
        return $this->is_active;
    }

    /**
     * @param string $is_active
     * @return $this
     */
    public function setIsActive(string $is_active): static
    {
        $this->is_active = $is_active;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsiteRootName(): ?string
    {
        return $this->website_root_name;
    }

    /**
     * @param string $website_root_name
     * @return $this
     */
    public function setWebsiteRootName(string $website_root_name): self
    {
        $this->website_root_name = $website_root_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsiteRootCode(): ?string
    {
        return $this->website_root_code;
    }

    /**
     * @param string $website_root_code
     * @return $this
     */
    public function setWebsiteRootCode(string $website_root_code): self
    {
        $this->website_root_code = $website_root_code;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSortOrder(): ?int
    {
        return $this->sort_order;
    }

    /**
     * @param int $sort_order
     * @return WebsiteRoot
     */
    public function setSortOrder(int $sort_order): static
    {
        $this->sort_order = $sort_order;
        return $this;
    }

    /**
     * @return Website|null
     */
    public function getDefaultWebsite(): ?Website
    {
        return $this->defaultWebsite;
    }

    /**
     * @param Website $website
     * @return $this
     */
    public function setDefaultWebsite(Website $website): static
    {
        $this->defaultWebsite = $website;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDefaultWebsiteId(): ?int
    {
        return $this->getDefaultWebsite()->getWebsiteId();
    }


    /**
     * @return string|null
     */
    public function getIsDefault(): ?string
    {
        return $this->is_default;
    }

    /**
     * @param string $is_default
     * @return $this
     */
    public function setIsDefault(string $is_default): self
    {
        $this->setData('is_default', $is_default);
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getWebsites(): ?Collection
    {
        return $this->websites;
    }

    /**
     * @param Website $website
     * @return $this
     */
    public function addWebsite(Website $website): static
    {
        if(!$this->websites->contains($website)) {
            $this->websites[] = $website;
            $website->setWebsiteRoot($this);
        }

        return $this;
    }

    /**
     * @param Website $website
     * @return $this
     */
    public function removeWebsite(Website $website): static
    {
        if($this->websites->removeElement($website)) {
            if($website->getWebsiteRoot() === $this) {
                $website->setWebsiteRoot(null);
            }
        }

        return $this;
    }
}
