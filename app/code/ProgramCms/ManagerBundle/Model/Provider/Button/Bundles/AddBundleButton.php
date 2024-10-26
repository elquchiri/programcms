<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ManagerBundle\Model\Provider\Button\Bundles;

use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class AddBundleButton
 * @package ProgramCms\ManagerBundle\Model\Provider\Button\Bundles
 */
class AddBundleButton implements ButtonProviderInterface
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * NewTemplateButton constructor.
     * @param Url $url
     */
    public function __construct(Url $url)
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
            'buttonAction' => $this->url->getUrlByRouteName('manager_bundle_browse'),
            'label' => 'Add Bundle'
        ];
    }
}