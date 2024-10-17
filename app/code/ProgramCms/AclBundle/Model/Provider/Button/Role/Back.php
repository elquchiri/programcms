<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Model\Provider\Button\Role;

use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class BackButton
 * @package ProgramCms\AclBundle\Model\Provider\Button\Role
 */
class Back implements ButtonProviderInterface
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * Back constructor.
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
            'buttonAction' => $this->url->getUrlByRouteName('acl_role_index'),
            'label' => 'back'
        ];
    }
}