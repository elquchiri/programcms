<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model;

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
}