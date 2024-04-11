<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Provider\DataSource;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;

/**
 * Class Websites
 * @package ProgramCms\WebsiteBundle\Model\Provider\DataSource
 */
class WebsiteViews extends \ProgramCms\UiBundle\Model\Provider\DataSource\Options
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
     * WebsiteViews constructor.
     * @param Request $request
     * @param WebsiteViewRepository $websiteViewRepository
     * @param WebsiteGroupRepository $websiteGroupRepository
     */
    public function __construct(
        Request $request,
        WebsiteViewRepository $websiteViewRepository,
        WebsiteGroupRepository $websiteGroupRepository
    )
    {
        $this->request = $request;
        $this->websiteViewRepository = $websiteViewRepository;
        $this->websiteGroupRepository = $websiteGroupRepository;
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        $options = [];

        if(!empty($this->request->getParam('id'))) {
            $groupId = $this->request->getParam('id');
            $websiteViews = $this->websiteGroupRepository
                ->findOneBy(['website_group_id' => $groupId])
                ->getWebsiteViews();
        }else {
            $websiteViews = $this->websiteViewRepository->findAll();
        }
        foreach($websiteViews as $view) {
            $options[$view->getWebsiteViewId()] = $view->getWebsiteViewName();
        }

        return $options;
    }
}