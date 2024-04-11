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

/**
 * Class Websites
 * @package ProgramCms\WebsiteBundle\Model\Provider\DataSource
 */
class Groups extends Options
{
    /**
     * @var Request
     */
    protected Request $request;
    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;
    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;

    /**
     * Websites constructor.
     * @param Request $request
     * @param WebsiteRepository $websiteRepository
     * @param WebsiteGroupRepository $websiteGroupRepository
     */
    public function __construct(
        Request $request,
        WebsiteRepository $websiteRepository,
        WebsiteGroupRepository $websiteGroupRepository
    )
    {
        $this->request = $request;
        $this->websiteRepository = $websiteRepository;
        $this->websiteGroupRepository = $websiteGroupRepository;
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        $options = [];

        if(in_array($this->request->getCurrentRouteName(), ['website_website_edit', 'website_website_new'])
            && !empty($this->request->getParam('id'))
        ) {
            $websiteId = $this->request->getParam('id');
            $groups = $this->websiteRepository
                ->findOneBy(['website_id' => $websiteId])
                ->getGroups();
        }else{
            $groups = $this->websiteGroupRepository->findAll();
        }
        /**
         * Populate Options
         */
        foreach($groups as $group) {
            $options[$group->getWebsiteGroupId()] = $group->getWebsiteGroupName();
        }

        return $options;
    }
}