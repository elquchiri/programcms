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
 * Class Websites
 * @package ProgramCms\WebsiteBundle\Model\Provider\DataSource
 */
class Websites extends Options
{
    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * Websites constructor.
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
        $options = [];
        $websites = $this->websiteRepository->findAll();
        foreach($websites as $website) {
            $options[$website->getWebsiteId()] = $website->getWebsiteName();
        }
        return $options;
    }
}