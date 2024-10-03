<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Migrations;

use ProgramCms\DataPatchBundle\Model\DataPatchInterface;
use ProgramCms\WebsiteBundle\Entity\Website;
use ProgramCms\WebsiteBundle\Entity\WebsiteGroup;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;

/**
 * Class WebsiteSetup
 * @package ProgramCms\WebsiteBundle\Migrations
 */
class WebsiteSetup implements DataPatchInterface
{
    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * WebsiteSetup constructor.
     * @param WebsiteRepository $websiteRepository
     */
    public function __construct(
        WebsiteRepository $websiteRepository
    )
    {
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * Setup Base Frontend Website
     */
    public function execute(): void
    {
        $website = new Website();
        $group = new WebsiteGroup();
        $view = new WebsiteView();

        $website
            ->setIsActive('on')
            ->setWebsiteCode('base')
            ->setSortOrder(1)
            ->setWebsiteName('Main Website')
            ->setDefaultGroup($group)
            ->setIsDefault(true);
        $group
            ->setWebsite($website)
            ->setIsActive('on')
            ->setSortOrder(1)
            ->setWebsiteGroupCode('base_group')
            ->setWebsiteGroupName('Main Website Group')
            ->setDefaultWebsiteView($view);
        $view
            ->setIsActive('on')
            ->setSortOrder(1)
            ->setWebsiteViewCode('default')
            ->setWebsiteViewName('Default View')
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