<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Model\Provider\Button;

use ProgramCms\RouterBundle\Service\UrlInterface as Url;

/**
 * Class BackToThemesButton
 * @package ProgramCms\ThemeBundle\Model\Provider\Button
 */
class BackToThemesButton implements \ProgramCms\UiBundle\DataProvider\ButtonProviderInterface
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * BackToWebsiteButton constructor.
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
            'buttonAction' => $this->url->getUrlByRouteName('theme_index_index'),
            'label' => 'back'
        ];
    }
}
