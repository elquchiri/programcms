<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Provider\DataSource;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\UiBundle\Model\Provider\DataSource\Options;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;

/**
 * Class WebsiteTree
 * @package ProgramCms\WebsiteBundle\Model\Provider\DataSource
 */
class WebsiteTree extends Options
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var WebsiteViewRepository
     */
    protected WebsiteViewRepository $websiteViewRepository;

    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;

    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * WebsiteViews constructor.
     * @param Request $request
     * @param WebsiteRepository $websiteRepository
     * @param WebsiteViewRepository $websiteViewRepository
     * @param WebsiteGroupRepository $websiteGroupRepository
     */
    public function __construct(
        Request $request,
        WebsiteRepository $websiteRepository,
        WebsiteViewRepository $websiteViewRepository,
        WebsiteGroupRepository $websiteGroupRepository
    )
    {
        $this->request = $request;
        $this->websiteViewRepository = $websiteViewRepository;
        $this->websiteGroupRepository = $websiteGroupRepository;
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