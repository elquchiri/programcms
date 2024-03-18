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
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;

/**
 * Class WebsiteManager
 * @package ProgramCms\WebsiteBundle\Model
 */
class WebsiteManager implements WebsiteManagerInterface
{
    /**
     * @var WebsiteViewRepository
     */
    protected WebsiteViewRepository $websiteViewRepository;

    /**
     * @var null
     */
    protected $currentWebsiteViewId = null;

    /**
     * @var WebsiteViewResolver
     */
    protected WebsiteViewResolver $websiteViewResolver;

    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;

    /**
     * WebsiteManager constructor.
     * @param WebsiteViewRepository $websiteViewRepository
     * @param WebsiteRepository $websiteRepository
     * @param WebsiteGroupRepository $websiteGroupRepository
     * @param WebsiteViewResolver $websiteViewResolver
     */
    public function __construct(
        WebsiteViewRepository $websiteViewRepository,
        WebsiteRepository $websiteRepository,
        WebsiteGroupRepository $websiteGroupRepository,
        WebsiteViewResolver $websiteViewResolver
    )
    {
        $this->websiteViewRepository = $websiteViewRepository;
        $this->websiteViewResolver = $websiteViewResolver;
        $this->websiteRepository = $websiteRepository;
        $this->websiteGroupRepository = $websiteGroupRepository;
    }

    /**
     * @param null $websiteViewId
     * @return WebsiteView
     */
    public function getWebsiteView($websiteViewId = null): WebsiteView
    {
        if (!isset($websiteViewId) || '' === $websiteViewId) {
            if (null === $this->currentWebsiteViewId) {
                $this->currentWebsiteViewId = $this->websiteViewResolver->getCurrentWebsiteViewId();
            }
            $websiteViewId = $this->currentWebsiteViewId;
        }

        return is_numeric($websiteViewId)
            ? $this->websiteViewRepository->getById($websiteViewId)
            : $this->websiteViewRepository->getByCode($websiteViewId);
    }

    /**
     * @return Website|null
     */
    public function getWebsite($websiteId = null)
    {
        if(isset($websiteId) && !empty($websiteId)) {
            return $this->websiteRepository->getById($websiteId);
        }

        return $this->websiteViewResolver->getCurrentWebsite();
    }

    /**
     * @param null $groupId
     * @return WebsiteGroup|null
     */
    public function getGroup($groupId = null)
    {
        if(isset($groupId) && !empty($groupId)) {
            return $this->websiteGroupRepository->getById($groupId);
        }

        return $this->websiteViewResolver->getCurrentGroup();
    }

    /**
     * @return WebsiteView[]
     */
    public function getWebsiteViews(): array
    {
        return $this->websiteViewRepository->findAll();
    }
}