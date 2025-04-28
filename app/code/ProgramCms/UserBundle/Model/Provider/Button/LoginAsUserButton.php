<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Button;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\RouterBundle\Service\UrlInterface;
use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class LoginAsUserButton
 * @package ProgramCms\UserBundle\Model\Provider\Button
 */
class LoginAsUserButton implements ButtonProviderInterface
{
    /**
     * @var UrlInterface
     */
    protected UrlInterface $url;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * LoginAsUserButton constructor.
     * @param UrlInterface $url
     * @param Request $request
     */
    public function __construct(UrlInterface $url, Request $request)
    {
        $this->url = $url;
        $this->request = $request;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        $userId = $this->request->getParam('id');

        return [
            'buttonType' => 'secondary',
            'buttonAction' => $this->url->getUrlByFullRouteName('frontend_user_account_loginasuser', ['id' => $userId]),
            'label' => 'Sign-In as User',
            'confirm' => [
                'title' => 'Sign-In as User',
                'text' => "Actions taken while in <span class='fw-bold' style='font-size: 14px;'>Authenticate as User</span> will affect actual user data. Please respect the user's privacy by asking for their consent before inspecting their user account.",
                'yes' => 'Sign-In as User',
                'no' => 'Cancel',
                '_blank' => true
            ]
        ];
    }
}