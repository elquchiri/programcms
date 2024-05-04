<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Entity;

use Doctrine\Common\Collections\Collection;
use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CoreBundle\App\ScopeInterface as AppScopeInterface;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class WebsiteGroup
 * @package ProgramCms\WebsiteBundle\Entity
 */
#[ORM\Entity(repositoryClass: WebsiteGroupRepository::class)]
class WebsiteGroup extends AbstractEntity implements AppScopeInterface
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
     * @var int|null
     */
    #[ORM\Column(nullable: true)]
    private ?int $is_active = null;

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
     * @var int|null
     */
    #[ORM\Column(nullable: true)]
    private ?int $sort_order = null;

    /**
     * @var WebsiteView|null
     */
    #[ORM\ManyToOne(targetEntity: WebsiteView::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: 'default_website_view_id', referencedColumnName: 'website_view_id')]
    private ?WebsiteView $defaultWebsiteView;

    /**
     * @var CategoryEntity|null
     */
    #[ORM\ManyToOne(targetEntity: CategoryEntity::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: 'root_category_id', referencedColumnName: 'entity_id')]
    private ?CategoryEntity $category = null;

    /**
     * @var ?Collection
     */
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
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        return $this->website_group_id;
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
     * @return int
     */
    public function getWebsiteId(): int
    {
        return $this->website->getWebsiteId();
    }

    /**
     * @return int|null
     */
    public function getIsActive(): ?int
    {
        return $this->is_active;
    }

    /**
     * @param string $is_active
     * @return $this
     */
    public function setIsActive(string $is_active): static
    {
        $this->is_active = $is_active === 'on' ? 1 : 0;
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
     * @return int|null
     */
    public function getSortOrder(): ?int
    {
        return $this->sort_order;
    }

    /**
     * @param string|int $sort_order
     * @return $this
     */
    public function setSortOrder(string|int $sort_order): static
    {
        $this->sort_order = (int) $sort_order;
        return $this;
    }

    /**
     * @return WebsiteView|null
     */
    public function getDefaultWebsiteView(): ?WebsiteView
    {
        return $this->defaultWebsiteView;
    }

    /**
     * @param WebsiteView $websiteView
     * @return $this
     */
    public function setDefaultWebsiteView(WebsiteView $websiteView): static
    {
        $this->defaultWebsiteView = $websiteView;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDefaultWebsiteViewId(): ?int
    {
        return $this->defaultWebsiteView->getWebsiteViewId();
    }

    /**
     * @return CategoryEntity|null
     */
    public function getCategory(): ?CategoryEntity
    {
        return $this->category;
    }

    /**
     * @param CategoryEntity $category
     * @return $this
     */
    public function setCategory(CategoryEntity $category): self
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

    /**
     * @return string|null
     */
    public function getCode()
    {
        return $this->getWebsiteGroupCode();
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->getWebsiteGroupId();
    }

    /**
     * @return string
     */
    public function getScopeType()
    {
        return ScopeInterface::SCOPE_GROUP;
    }

    /**
     * @return string
     */
    public function getScopeTypeName()
    {
        return 'Website Group';
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->getWebsiteGroupName();
    }
}
