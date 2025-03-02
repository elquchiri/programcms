<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Button;

use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class NewUserGroupButton
 * @package ProgramCms\UserBundle\Model\Provider\Button
 */
class NewUserGroupButton implements ButtonProviderInterface
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * NewUserGroupButton constructor.
     * @param Url $url
     */
    public function __construct(
        Url $url
    )
    {
        $this->url = $url;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'primary',
            'class' => 'btn-primary',
            'buttonAction' => $this->url->getUrlByRouteName('user_group_new'),
            'label' => 'New Group'
        ];
    }
}