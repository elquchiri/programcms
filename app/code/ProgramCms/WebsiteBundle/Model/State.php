<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model;

use ProgramCms\CoreBundle\App\Config;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;

/**
 * Class State
 * @package ProgramCms\WebsiteBundle\Model
 */
class State
{

    const LOCALE_CONFIG = 'general/local_options/locale';

    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * @var WebsiteViewRepository
     */
    protected WebsiteViewRepository $websiteViewRepository;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * State constructor.
     * @param Config $config
     * @param WebsiteRepository $websiteRepository
     * @param WebsiteViewRepository $websiteViewRepository
     */
    public function __construct(
        Config $config,
        WebsiteRepository $websiteRepository,
        WebsiteViewRepository $websiteViewRepository
    )
    {
        $this->websiteRepository = $websiteRepository;
        $this->websiteViewRepository = $websiteViewRepository;
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getLocale($runType, $runCode)
    {
        return $this->config->getValue(
            self::LOCALE_CONFIG,
            'website_view',
            $this->getCurrentWebsiteView($runType, $runCode)->getWebsiteViewId()
        );
    }

    /**
     * @return WebsiteView|null
     */
    public function getCurrentWebsiteView($runType, $runCode)
    {
        if ($runType === 'website') {
            $website = $this->websiteRepository->getByCode($runCode);
            return $website->getDefaultGroup()->getDefaultWebsiteView();
        } elseif ($runType === 'website_view') {
            return $this->websiteViewRepository->getByCode($runCode);
        }

        $website = $this->websiteRepository->getDefaultWebsite();
        return $website->getDefaultGroup()->getDefaultWebsiteView();
    }
}