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

/**
 * Class ResetPasswordButton
 * @package ProgramCms\UserBundle\Model\Provider\Button
 */
class ResetPasswordButton implements \ProgramCms\UiBundle\DataProvider\ButtonProviderInterface
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
     * ResetPasswordButton constructor.
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
            'buttonAction' => $this->url->getUrlByRouteName('user_account_reset', ['id' => $userId]),
            'label' => 'Reset Password',
            'confirm' => [
                'title' => 'Account Recovery',
                'text' => 'You are about to send user an account recovery email',
                'yes' => 'Send Recovery Email'
            ]
        ];
    }
}