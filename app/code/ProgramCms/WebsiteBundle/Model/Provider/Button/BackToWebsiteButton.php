<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Provider\Button;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;

/**
 * Class AddGroupButton
 * @package ProgramCms\WebsiteBundle\Model\Provider\Button
 */
class BackToWebsiteButton implements \ProgramCms\UiBundle\DataProvider\ButtonProviderInterface
{
    /**
     * @var Url
     */
    protected Url $url;
    /**
     * @var Request
     */
    protected Request $request;
    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;

    /**
     * BackToWebsiteButton constructor.
     * @param Url $url
     * @param Request $request
     * @param WebsiteGroupRepository $websiteGroupRepository
     */
    public function __construct(
        Url $url,
        Request $request,
        WebsiteGroupRepository $websiteGroupRepository
    )
    {
        $this->url = $url;
        $this->request = $request;
        $this->websiteGroupRepository = $websiteGroupRepository;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        $id = $this->url->getRouteName() === 'website_websitegroup_new' ?
            $this->request->getParam('website_id') :
            $this->websiteGroupRepository->findOneBy([
                'website_group_id' => $this->request->getParam('id')
            ])->getWebsite()->getWebsiteId();

        return [
            'buttonType' => 'back',
            'buttonAction' => $this->url->getUrlByRouteName('website_website_edit', ['id' => $id]),
            'label' => 'back'
        ];
    }
}