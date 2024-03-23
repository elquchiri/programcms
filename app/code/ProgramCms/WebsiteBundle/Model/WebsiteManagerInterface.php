<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model;

use ProgramCms\WebsiteBundle\Entity\Website;
use ProgramCms\WebsiteBundle\Entity\WebsiteGroup;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;

/**
 * Interface WebsiteManagerInterface
 * @package ProgramCms\WebsiteBundle\Model
 */
interface WebsiteManagerInterface
{
    /**
     * @param null $websiteViewId
     * @return WebsiteView
     */
    public function getWebsiteView($websiteViewId = null): WebsiteView;

    /**
     * @param null $websiteId
     * @return Website|null
     */
    public function getWebsite($websiteId = null): ?Website;

    /**
     * @param null $groupId
     * @return WebsiteGroup|null
     */
    public function getGroup($groupId = null): ?WebsiteGroup;

    /**
     * @return array
     */
    public function getWebsiteViews(): array;
}