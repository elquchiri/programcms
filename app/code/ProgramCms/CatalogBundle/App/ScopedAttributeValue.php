<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\App;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValue;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;

/**
 * Class ScopedAttributeValue
 * @package ProgramCms\CatalogBundle\App
 */
#[MappedSuperclass]
abstract class ScopedAttributeValue extends AttributeValue implements ScopedAttributeValueInterface
{
    /**
     * @var WebsiteView|null
     */
    #[ORM\OneToOne(targetEntity: WebsiteView::class)]
    #[ORM\JoinColumn(name: "website_view", referencedColumnName: "website_view_id")]
    protected ?WebsiteView $websiteView = null;

    /**
     * @return WebsiteView|null
     */
    public function getWebsiteView(): ?WebsiteView
    {
        return $this->websiteView;
    }

    /**
     * @param WebsiteView $websiteView
     * @return $this
     */
    public function setWebsiteView(WebsiteView $websiteView): static
    {
        $this->websiteView = $websiteView;
        return $this;
    }
}