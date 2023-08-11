<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Provider\DataSource;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;

/**
 * Class Websites
 * @package ProgramCms\WebsiteBundle\Model\Provider\DataSource
 */
class Websites extends \ProgramCms\UiBundle\Model\Provider\DataSource\Options
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
     * Websites constructor.
     * @param Request $request
     * @param WebsiteRepository $websiteRepository
     */
    public function __construct(
        Request $request,
        WebsiteRepository $websiteRepository,
    )
    {
        $this->request = $request;
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        $options = [];

        $websites = $this->websiteRepository->findAll();
        /**
         * Populate Options
         */
        foreach($websites as $website) {
            $options[$website->getWebsiteId()] = $website->getWebsiteName();
        }

        return $options;
    }
}