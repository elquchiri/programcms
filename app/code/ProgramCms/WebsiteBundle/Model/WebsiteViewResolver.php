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
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;

/**
 * Class WebsiteViewResolver
 * @package ProgramCms\WebsiteBundle\Model
 */
class WebsiteViewResolver
{
    /**
     * @var \ProgramCms\CoreBundle\App\State
     */
    protected \ProgramCms\CoreBundle\App\State $state;

    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * @var WebsiteViewRepository
     */
    protected WebsiteViewRepository $websiteViewRepository;

    /**
     * WebsiteViewResolver constructor.
     * @param \ProgramCms\CoreBundle\App\State $state
     * @param WebsiteRepository $websiteRepository
     * @param WebsiteViewRepository $websiteViewRepository
     */
    public function __construct(
        \ProgramCms\CoreBundle\App\State $state,
        WebsiteRepository $websiteRepository,
        WebsiteViewRepository $websiteViewRepository
    )
    {
        $this->state = $state;
        $this->websiteRepository = $websiteRepository;
        $this->websiteViewRepository = $websiteViewRepository;
    }

    /**
     * @return int|null
     */
    public function getCurrentWebsiteViewId(): ?int
    {
        return $this->getCurrentWebsiteView()->getWebsiteViewId();
    }

    /**
     * @return WebsiteView|null
     */
    public function getCurrentWebsiteView(): ?WebsiteView
    {
        $runType = $this->state->getCurrentRunType();
        $runCode = $this->state->getCurrentRunCode();

        if ($runType === 'website') {
            $website = $this->websiteRepository->getByCode($runCode);
            return $website->getDefaultGroup()->getDefaultWebsiteView();
        } elseif ($runType === 'website_view') {
            return $this->websiteViewRepository->getByCode($runCode);
        }

        $website = $this->websiteRepository->getDefaultWebsite();
        return $website->getDefaultGroup()->getDefaultWebsiteView();
    }

    /**
     * @return Website|null
     */
    public function getCurrentWebsite()
    {
        return $this->getCurrentWebsiteView()->getWebsiteGroup()->getWebsite();
    }

    /**
     * @return WebsiteGroup|null
     */
    public function getCurrentGroup()
    {
        return $this->getCurrentWebsite()->getDefaultGroup();
    }
}