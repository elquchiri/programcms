<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Entity;

use Doctrine\Common\Collections\Collection;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteRepository::class)]
class Website extends \ProgramCms\CoreBundle\Model\Db\Entity\Entity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $website_id = null;
    /**
     * @var WebsiteRoot|null
     */
    #[ORM\ManyToOne(targetEntity: WebsiteRoot::class, inversedBy: 'websites')]
    #[ORM\JoinColumn(name: 'website_root_id', referencedColumnName: 'website_root_id')]
    private ?WebsiteRoot $websiteRoot = null;
    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $website_code = null;
    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $website_name = null;
    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $root_category_id = null;

    #[ORM\OneToMany(mappedBy: 'website', targetEntity: WebsiteView::class)]
    private ?Collection $websiteViews = null;

    /**
     * @return int|null
     */
    public function getWebsiteId(): ?int
    {
        return $this->website_id;
    }

    /**
     * @param int $website_id
     * @return $this
     */
    public function setWebsiteId(int $website_id): self
    {
        $this->website_id = $website_id;

        return $this;
    }

    /**
     * @return WebsiteRoot|null
     */
    public function getWebsiteRoot(): ?WebsiteRoot
    {
        return $this->websiteRoot;
    }

    /**
     * @param WebsiteRoot $websiteRoot
     * @return $this
     */
    public function setWebsiteRoot(WebsiteRoot $websiteRoot): self
    {
        $this->websiteRoot = $websiteRoot;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsiteCode(): ?string
    {
        return $this->website_code;
    }

    /**
     * @param string $website_code
     * @return $this
     */
    public function setWebsiteCode(string $website_code): self
    {
        $this->website_code = $website_code;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsiteName(): ?string
    {
        return $this->website_name;
    }

    /**
     * @param string $website_name
     * @return $this
     */
    public function setWebsiteName(string $website_name): self
    {
        $this->website_name = $website_name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRootCategoryId(): ?string
    {
        return $this->root_category_id;
    }

    /**
     * @param string $root_category_id
     * @return $this
     */
    public function setRootCategoryId(string $root_category_id): self
    {
        $this->root_category_id = $root_category_id;

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getWebsiteViews(): ?Collection
    {
        return $this->websiteViews;
    }

    /**
     * @param WebsiteView $websiteView
     * @return $this
     */
    public function addWebsiteView(WebsiteView $websiteView): static
    {
        if(!$this->websiteViews->contains($websiteView)) {
            $this->websiteViews[] = $websiteView;
            $websiteView->setWebsite($this);
        }

        return $this;
    }

    /**
     * @param WebsiteView $websiteView
     * @return $this
     */
    public function removeWebsiteView(WebsiteView $websiteView): static
    {
        if($this->websiteViews->removeElement($websiteView)) {
            if($websiteView->getWebsite() === $this) {
                $websiteView->setWebsite(null);
            }
        }

        return $this;
    }
}
