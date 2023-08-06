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
use ProgramCms\WebsiteBundle\Repository\WebsiteRootRepository;

/**
 * Class Websites
 * @package ProgramCms\WebsiteBundle\Model\Provider\DataSource
 */
class Websites extends \ProgramCms\UiBundle\Model\Provider\DataSource\Options
{
    protected Request $request;
    protected WebsiteRootRepository $websiteRootRepository;
    protected WebsiteRepository $websiteRepository;

    public function __construct(
        Request $request,
        WebsiteRootRepository $websiteRootRepository,
        WebsiteRepository $websiteRepository
    )
    {
        $this->request = $request;
        $this->websiteRootRepository = $websiteRootRepository;
        $this->websiteRepository = $websiteRepository;
    }

    public function getOptionsArray(): array
    {
        $options = [];

        if(!empty($this->request->getParam('website_root'))) {
            $websiteRootId = $this->request->getParam('id');
            $websites = $this->websiteRootRepository
                ->findOneBy(['website_root_id' => $websiteRootId])
                ->getWebsites();
        }
        $websites = $this->websiteRepository->findAll();
        foreach($websites as $website) {
            $options[$website->getWebsiteId()] = $website->getWebsiteName();
        }

        return $options;
    }
}