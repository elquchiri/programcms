<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Button;

use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class BackToUserGroupsButton
 * @package ProgramCms\UserBundle\Model\Provider\Button
 */
class BackToUserGroupsButton implements ButtonProviderInterface
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * BackToUsersButton constructor.
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
            'buttonType' => 'back',
            'class' => 'back',
            'buttonAction' => $this->url->getUrlByRouteName('user_group_index'),
            'label' => 'back'
        ];
    }
}