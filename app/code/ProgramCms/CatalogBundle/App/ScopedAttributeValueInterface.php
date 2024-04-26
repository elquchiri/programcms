<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\App;

use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValueInterface;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;

/**
 * Interface ScopedAttributeValueInterface
 * @package ProgramCms\CatalogBundle\App
 */
interface ScopedAttributeValueInterface extends AttributeValueInterface
{
    /**
     * @return WebsiteView|null
     */
    public function getWebsiteView(): ?WebsiteView;

    /**
     * @param WebsiteView $websiteView
     * @return $this
     */
    public function setWebsiteView(WebsiteView $websiteView): static;
}