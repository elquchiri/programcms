<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\Entity;

use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use ProgramCms\RewriteBundle\Repository\UrlRewriteRepository;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;

/**
 * Class UrlRewrite
 * @package ProgramCms\RewriteBundle\Entity
 */
#[ORM\Entity(repositoryClass: UrlRewriteRepository::class)]
class UrlRewrite extends AbstractEntity
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $url_rewrite_id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string')]
    private ?string $request_path;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string')]
    private ?string $target_path;

    /**
     * @var int|null
     */
    #[ORM\Column(type: 'integer')]
    private ?int $redirect_type;

    /**
     * @var WebsiteView|null
     */
    #[ORM\ManyToOne(targetEntity: WebsiteView::class)]
    #[ORM\JoinColumn(name: 'website_view_id', referencedColumnName: 'website_view_id')]
    private ?WebsiteView $websiteView;

    /**
     * @param int $urlRewriteId
     * @return $this
     */
    public function setUrlRewriteId(int $urlRewriteId): self
    {
        $this->url_rewrite_id = $urlRewriteId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUrlRewriteId(): ?int
    {
        return $this->url_rewrite_id;
    }

    /**
     * @param string $requestPath
     * @return $this
     */
    public function setRequestPath(string $requestPath): self
    {
        $this->request_path = $requestPath;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRequestPath(): ?string
    {
        return $this->request_path;
    }

    /**
     * @param string $targetPath
     * @return $this
     */
    public function setTargetPath(string $targetPath): self
    {
        $this->target_path = $targetPath;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTargetPath(): ?string
    {
        return $this->target_path;
    }

    /**
     * @param int $redirectType
     * @return $this
     */
    public function setRedirectType(int $redirectType): self
    {
        $this->redirect_type = $redirectType;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRedirectType(): ?int
    {
        return $this->redirect_type;
    }

    /**
     * @param WebsiteView $websiteView
     * @return $this
     */
    public function setWebsiteView(WebsiteView $websiteView): self
    {
        $this->websiteView = $websiteView;
        return $this;
    }

    /**
     * @return WebsiteView|null
     */
    public function getWebsiteView(): ?WebsiteView
    {
        return $this->websiteView;
    }
}