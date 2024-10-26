<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Provider\Button;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;

/**
 * Class AddGroupButton
 * @package ProgramCms\WebsiteBundle\Model\Provider\Button
 */
class RemoveWebsiteViewButton implements \ProgramCms\UiBundle\DataProvider\ButtonProviderInterface
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
     * RemoveWebsiteButton constructor.
     * @param Url $url
     * @param Request $request
     */
    public function __construct(
        Url $url,
        Request $request
    )
    {
        $this->url = $url;
        $this->request = $request;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'secondary',
            'buttonAction' => $this->url->getUrlByRouteName('website_websiteview_remove', ['website_view_id' => $this->request->getParam('id')]),
            'label' => 'Remove'
        ];
    }
}