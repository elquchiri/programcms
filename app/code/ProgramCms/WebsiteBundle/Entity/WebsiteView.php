<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Entity;

use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WebsiteViewRepository::class)]
class WebsiteView extends \ProgramCms\CoreBundle\Model\Db\Entity\Entity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $website_view_id = null;
    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $website_view_code = null;
    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $website_view_name = null;
    /**
     * @var WebsiteGroup|null
     */
    #[ORM\ManyToOne(targetEntity: WebsiteGroup::class, inversedBy: 'websiteViews')]
    #[ORM\JoinColumn(name: 'website_group_id', referencedColumnName: 'website_group_id')]
    private ?WebsiteGroup $websiteGroup = null;
    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $is_active = null;

    /**
     * @return int|null
     */
    public function getWebsiteViewId(): ?int
    {
        return $this->website_view_id;
    }

    /**
     * @param int $website_view_id
     * @return $this
     */
    public function setWebsiteViewId(int $website_view_id): self
    {
        $this->website_view_id = $website_view_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsiteViewCode(): ?string
    {
        return $this->website_view_code;
    }

    /**
     * @param string $website_view_code
     * @return $this
     */
    public function setWebsiteViewCode(string $website_view_code): self
    {
        $this->website_view_code = $website_view_code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWebsiteViewName(): ?string
    {
        return $this->website_view_name;
    }

    /**
     * @param string $website_view_name
     * @return $this
     */
    public function setWebsiteViewName(string $website_view_name): self
    {
        $this->website_view_name = $website_view_name;
        return $this;
    }

    /**
     * @return WebsiteGroup|null
     */
    public function getWebsiteGroup(): ?WebsiteGroup
    {
        return $this->websiteGroup;
    }

    /**
     * @param WebsiteGroup $websiteGroup
     * @return $this
     */
    public function setWebsiteGroup(WebsiteGroup $websiteGroup): self
    {
        $this->websiteGroup = $websiteGroup;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return (bool) $this->is_active;
    }

    /**
     * @param int $is_active
     * @return $this
     */
    public function setIsActive(int $is_active): self
    {
        $this->is_active = $is_active;
        return $this;
    }
}
