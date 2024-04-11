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
use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;

/**
 * Class BackToWebsiteGroupButton
 * @package ProgramCms\WebsiteBundle\Model\Provider\Button
 */
class BackToWebsiteGroupButton implements ButtonProviderInterface
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
     * @var WebsiteViewRepository
     */
    protected WebsiteViewRepository $websiteViewRepository;

    /**
     * BackToWebsiteGroupButton constructor.
     * @param Url $url
     * @param Request $request
     * @param WebsiteViewRepository $websiteViewRepository
     */
    public function __construct(
        Url $url,
        Request $request,
        WebsiteViewRepository $websiteViewRepository
    )
    {
        $this->url = $url;
        $this->request = $request;
        $this->websiteViewRepository = $websiteViewRepository;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        $id = $this->url->getRouteName() === 'website_websiteview_new' ?
            $this->request->getParam('website_group_id') :
            $this->websiteViewRepository->findOneBy([
                'website_view_id' => $this->request->getParam('id')
            ])->getWebsiteGroup()->getWebsiteGroupId();

        return [
            'buttonType' => 'back',
            'class' => 'back',
            'buttonAction' => $this->url->getUrlByRouteName('website_websitegroup_edit', ['id' => $id]),
            'label' => 'back'
        ];
    }
}