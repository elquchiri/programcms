<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\Website;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class IndexController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml\Website
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var Url
     */
    protected Url $url;
    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param Url $url
     * @param WebsiteRepository $websiteRepository
     */
    public function __construct(
        Context $context,
        Url $url,
        WebsiteRepository $websiteRepository,
    )
    {
        parent::__construct($context);
        $this->url = $url;
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * Redirect to Default WebsiteRoot Edit Controller
     * @return RedirectResponse
     */
    public function execute()
    {
        $defaultWebsite = $this->websiteRepository->findOneBy(['is_default' => 1]);
        return $this->redirect($this->url->getUrlByRouteName('website_website_edit', ['id' => $defaultWebsite->getWebsiteId()]));
    }
}