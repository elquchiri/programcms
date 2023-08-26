<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Toolbar;

use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;

/**
 * Class WebsiteSwitcher
 * @package ProgramCms\UiBundle\Block\Toolbar
 */
class WebsiteSwitcher extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/toolbar/website_switcher.html.twig";
    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;
    /**
     * @var Url
     */
    protected Url $url;
    /**
     * @var WebsiteViewRepository
     */
    protected WebsiteViewRepository $websiteViewRepository;
    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;

    /**
     * WebsiteSwitcher constructor.
     * @param Context $context
     * @param WebsiteRepository $websiteRepository
     * @param WebsiteGroupRepository $websiteGroupRepository
     * @param WebsiteViewRepository $websiteViewRepository
     * @param Url $url
     * @param Request $request
     * @param array $data
     */
    public function __construct(
        Context $context,
        WebsiteRepository $websiteRepository,
        WebsiteGroupRepository $websiteGroupRepository,
        WebsiteViewRepository $websiteViewRepository,
        Url $url,
        Request $request,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->websiteRepository = $websiteRepository;
        $this->url = $url;
        $this->request = $request;
        $this->websiteViewRepository = $websiteViewRepository;
        $this->websiteGroupRepository = $websiteGroupRepository;
    }

    /**
     * Get All Websites
     * @return array
     */
    public function getAllWebsites(): array
    {
        return $this->websiteRepository->findAll();
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        $currentUrl = $this->url->getCurrentUrl();
        return preg_replace('/\/(website|website_group|website_view)\/\d+$/', '', $currentUrl);
    }

    /**
     * @return string
     */
    public function getCurrentScopeLabel(): string
    {
        if(!empty($websiteId = $this->request->getParam('website'))) {
            $website = $this->websiteRepository->getById($websiteId);
            return $website->getWebsiteName();
        }else if(!empty($websiteGroupId = $this->request->getParam('website_group'))) {
            $websiteGroup = $this->websiteGroupRepository->getById($websiteGroupId);
            return $websiteGroup->getWebsiteGroupName();
        }else if(!empty($websiteViewId = $this->request->getParam('website_view'))) {
            $websiteView = $this->websiteViewRepository->getById($websiteViewId);
            return $websiteView->getWebsiteViewName();
        }

        return $this->trans('All Websites');
    }
}