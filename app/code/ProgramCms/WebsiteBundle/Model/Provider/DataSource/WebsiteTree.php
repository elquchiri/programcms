<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Provider\DataSource;

use ProgramCms\UiBundle\Model\Provider\DataSource\Options;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;

/**
 * Class WebsiteTree
 * @package ProgramCms\WebsiteBundle\Model\Provider\DataSource
 */
class WebsiteTree extends Options
{
    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * WebsiteTree constructor.
     * @param WebsiteRepository $websiteRepository
     */
    public function __construct(
        WebsiteRepository $websiteRepository,
    )
    {
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        $tree = [];
        foreach($this->websiteRepository->findAll() as $website) {
            foreach($website->getGroups() as $group) {
                foreach($group->getWebsiteViews() as $websiteView) {
                    $tree[$website->getWebsiteName()][$group->getWebsiteGroupName()][$websiteView->getWebsiteViewId()] = $websiteView->getWebsiteViewName();
                }
            }
        }
        return $tree;
    }
}