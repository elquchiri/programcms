<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\WebsiteBundle\Model\WebsiteManager;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use ProgramCms\WebsiteBundle\Helper\Config as ConfigHelper;

/**
 * Class WebsiteSwitcher
 * @package ProgramCms\WebsiteBundle\Block
 */
class WebsiteSwitcher extends Template
{
    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * @var WebsiteManager
     */
    protected WebsiteManager $websiteManager;

    /**
     * @var ConfigHelper
     */
    protected ConfigHelper $configHelper;

    /**
     * WebsiteSwitcher constructor.
     * @param Context $context
     * @param WebsiteRepository $websiteRepository
     * @param WebsiteManager $websiteManager
     * @param ConfigHelper $configHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        WebsiteRepository $websiteRepository,
        WebsiteManager $websiteManager,
        ConfigHelper $configHelper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->websiteRepository = $websiteRepository;
        $this->websiteManager = $websiteManager;
        $this->configHelper = $configHelper;
    }

    /**
     * @return array
     */
    public function getWebsites(): array
    {
        $websites = [];
        $currentWebsite = $this->websiteManager->getWebsite();

        foreach($this->websiteRepository->findAll() as $website) {
            if($currentWebsite === $website) {
                continue;
            }
            $websites[] = [
                'code' => $website->getWebsiteCode(),
                'name' => $website->getWebsiteName(),
                'url' => $this->configHelper->getBaseUrl('website', $website->getWebsiteId())
            ];
        }
        return $websites;
    }

    /**
     * @return string|null
     */
    public function getCurrentWebsiteName(): ?string
    {
        return $this->websiteManager->getWebsite()->getWebsiteName();
    }
}