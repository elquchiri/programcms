<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Entity;

use Doctrine\Common\Collections\Collection;
use ProgramCms\CatalogBundle\Entity\Category;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteGroupRepository::class)]
class WebsiteGroup extends \ProgramCms\CoreBundle\Model\Db\Entity\Entity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $website_group_id = null;
    /**
     * @var Website|null
     */
    #[ORM\ManyToOne(targetEntity: Website::class, inversedBy: 'groups')]
    #[ORM\JoinColumn(name: 'website_id', referencedColumnName: 'website_id')]
    private ?Website $website = null;
    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $website_group_code = null;
    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $website_group_name = null;
    /**
     * @var Category|null
     */
    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: 'root_category_id', referencedColumnName: 'entity_id')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'websiteGroup', targetEntity: WebsiteView::class)]
    private ?Collection $websiteViews = null;

    /**
     * @return int|null
     */
    public function getWebsiteGroupId(): ?int
    {
        return $this->website_group_id;
    }

    /**
     * @param int $website_group_id
     * @return $this
     */
    public function setWebsiteGroupId(int $website_group_id): self
    {
        $this->website_group_id = $website_group_id;
        return $this;
    }

    /**
     * @return Website|null
     */
    public function getWebsite(): ?Website
    {
        return $this->website;
    }

    /**
     * @param Website $website
     * @return $this
     */
    public function setWebsite(Website $website): self
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsiteGroupCode(): ?string
    {
        return $this->website_group_code;
    }

    /**
     * @param string $website_group_code
     * @return $this
     */
    public function setWebsiteGroupCode(string $website_group_code): self
    {
        $this->website_group_code = $website_group_code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsiteGroupName(): ?string
    {
        return $this->website_group_name;
    }

    /**
     * @param string $website_group_name
     * @return $this
     */
    public function setWebsiteGroupName(string $website_group_name): self
    {
        $this->website_group_name = $website_group_name;
        return $this;
    }

    /**
     * @return Category|null
     */
    public function getRootCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @return $this
     */
    public function setRootCategory(Category $category): self
    {
        $this->category = $category;
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
            $websiteView->setWebsiteGroup($this);
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
            if($websiteView->getWebsiteGroup() === $this) {
                $websiteView->setWebsiteGroup(null);
            }
        }

        return $this;
    }
}
