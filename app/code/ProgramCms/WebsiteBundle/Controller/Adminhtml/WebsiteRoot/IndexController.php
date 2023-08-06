<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Controller\Adminhtml\WebsiteRoot;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Repository\WebsiteRootRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class IndexController
 * @package ProgramCms\WebsiteBundle\Controller\Adminhtml
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var Url
     */
    protected Url $url;
    /**
     * @var WebsiteRootRepository
     */
    protected WebsiteRootRepository $websiteRootRepository;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param Url $url
     * @param WebsiteRootRepository $websiteRootRepository
     */
    public function __construct(
        Context $context,
        Url $url,
        WebsiteRootRepository $websiteRootRepository,
    )
    {
        parent::__construct($context);
        $this->url = $url;
        $this->websiteRootRepository = $websiteRootRepository;
    }

    /**
     * Redirect to Default WebsiteRoot Edit Controller
     * @return RedirectResponse
     */
    public function execute()
    {
        $defaultWebsiteRoot = $this->websiteRootRepository->findOneBy(['is_default' => 1]);
        return $this->redirect($this->url->getUrlByRouteName('website_websiteroot_edit', ['id' => $defaultWebsiteRoot->getWebsiteRootId()]));
    }
}