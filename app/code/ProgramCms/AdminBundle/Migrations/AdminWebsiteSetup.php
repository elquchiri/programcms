<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Migrations;

use ProgramCms\DataPatchBundle\Model\DataPatchInterface;
use ProgramCms\WebsiteBundle\Entity\Website;
use ProgramCms\WebsiteBundle\Entity\WebsiteGroup;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;

/**
 * Class AdminWebsiteSetup
 * @package ProgramCms\WebsiteBundle\Migrations
 */
class AdminWebsiteSetup implements DataPatchInterface
{
    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * AdminWebsiteSetup constructor.
     * @param WebsiteRepository $websiteRepository
     */
    public function __construct(
        WebsiteRepository $websiteRepository
    )
    {
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * Setup Admin Website
     */
    public function execute(): void
    {
        $website = new Website();
        $group = new WebsiteGroup();
        $view = new WebsiteView();

        $website
            ->setIsActive('on')
            ->setWebsiteCode('admin')
            ->setSortOrder(0)
            ->setWebsiteName('Admin')
            ->setDefaultGroup($group);
        $group
            ->setWebsite($website)
            ->setIsActive('on')
            ->setSortOrder(0)
            ->setWebsiteGroupCode('admin')
            ->setWebsiteGroupName('Default')
            ->setDefaultWebsiteView($view);
        $view
            ->setIsActive('on')
            ->setSortOrder(0)
            ->setWebsiteViewCode('admin')
            ->setWebsiteViewName('Admin')
            ->setWebsiteGroup($group);

        // Save website and its dependencies.
        $this->websiteRepository->save($website);
    }

    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }
}