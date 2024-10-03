<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Migrations;

use ProgramCms\CatalogBundle\Migrations\Category\CreateDefaultCategory;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
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
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * WebsiteSetup constructor.
     * @param WebsiteRepository $websiteRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        WebsiteRepository $websiteRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->websiteRepository = $websiteRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Setup Base Frontend Website
     */
    public function execute(): void
    {
        $website = new Website();
        $group = new WebsiteGroup();
        $view = new WebsiteView();
        $defaultCategory = $this->categoryRepository->getDefaultCategory();

        $website
            ->setIsActive('on')
            ->setWebsiteCode('base')
            ->setSortOrder(1)
            ->setWebsiteName('Main Website')
            ->setDefaultGroup($group);
        $group
            ->setWebsite($website)
            ->setIsActive('on')
            ->setSortOrder(1)
            ->setWebsiteGroupCode('base_group')
            ->setWebsiteGroupName('Main Website Group')
            ->setCategory($defaultCategory)
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
        return [CreateDefaultCategory::class];
    }
}