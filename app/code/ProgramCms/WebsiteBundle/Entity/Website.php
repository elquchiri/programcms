<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\WebsiteBundle\Model\ScopeInterface;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use ProgramCms\CoreBundle\App\ScopeInterface as AppScopeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Website
 * @package ProgramCms\WebsiteBundle\Entity
 */
#[ORM\Entity(repositoryClass: WebsiteRepository::class)]
class Website extends AbstractEntity implements AppScopeInterface
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $website_id = null;

    /**
     * @var int|null
     */
    #[ORM\Column(nullable: true)]
    private ?int $is_active = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $website_name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $website_code = null;

    /**
     * @var int|null
     */
    #[ORM\Column(nullable: true)]
    private ?int $sort_order = null;

    /**
     * @var WebsiteGroup|null
     */
    #[ORM\ManyToOne(targetEntity: WebsiteGroup::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: 'default_website_group_id', referencedColumnName: 'website_group_id')]
    private ?WebsiteGroup $defaultGroup = null;

    /**
     * @var int|null
     */
    #[ORM\Column(nullable: true)]
    private ?int $is_default = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'website', targetEntity: WebsiteGroup::class)]
    private Collection $groups;

    /**
     * Website constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->groups = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getWebsiteId(): ?int
    {
        return $this->website_id;
    }

    /**
     * @return int|null
     */
    public function getEntityId(): ?int
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
     * @return int|null
     */
    public function getIsActive(): ?int
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     * @return $this
     */
    public function setIsActive(mixed $is_active): static
    {
        $this->is_active = $is_active === 'on' ? 1 : 0;
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
     * @return WebsiteGroup|null
     */
    public function getDefaultGroup(): ?WebsiteGroup
    {
        return $this->defaultGroup;
    }

    /**
     * @param WebsiteGroup $group
     * @return $this
     */
    public function setDefaultGroup(WebsiteGroup $group): static
    {
        $this->defaultGroup = $group;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDefaultWebsiteGroupId(): ?int
    {
        return $this->getDefaultGroup()->getWebsiteGroupId();
    }


    /**
     * @return string|null
     */
    public function getIsDefault(): ?string
    {
        return $this->is_default;
    }

    /**
     * @param int $is_default
     * @return $this
     */
    public function setIsDefault(int $is_default): self
    {
        $this->is_default = $is_default;
        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getGroups(): ?Collection
    {
        return $this->groups;
    }

    /**
     * @param WebsiteGroup $websiteGroup
     * @return $this
     */
    public function addGroup(WebsiteGroup $websiteGroup): static
    {
        if(!$this->groups->contains($websiteGroup)) {
            $this->groups[] = $websiteGroup;
            $websiteGroup->setWebsite($this);
        }

        return $this;
    }

    /**
     * @param Website $website
     * @return $this
     */
    public function removeGroup(WebsiteGroup $websiteGroup): static
    {
        if($this->groups->removeElement($websiteGroup)) {
            if($websiteGroup->getWebsite() === $this) {
                $websiteGroup->setWebsite(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode()
    {
        return $this->getWebsiteCode();
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->getWebsiteId();
    }

    /**
     * @return string
     */
    public function getScopeType()
    {
        return ScopeInterface::SCOPE_WEBSITE;
    }

    /**
     * @return string
     */
    public function getScopeTypeName()
    {
        return 'Website';
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->getWebsiteName();
    }
}
