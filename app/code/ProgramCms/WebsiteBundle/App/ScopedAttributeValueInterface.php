<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\App;

use ProgramCms\EavBundle\Model\Entity\Attribute\AttributeValueInterface;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;

/**
 * Interface ScopedAttributeValueInterface
 * @package ProgramCms\WebsiteBundle\App
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