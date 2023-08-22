<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Ui\Grid\Column;

use ProgramCms\RouterBundle\Service\Url;

/**
 * Class ThemeActions
 * @package ProgramCms\ThemeBundle\Ui\Grid\Column
 */
class ThemeActions extends \ProgramCms\UiBundle\Component\Grid\Column
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * ThemeActions constructor.
     * @param Url $url
     */
    public function __construct(
        Url $url
    )
    {
        $this->url = $url;
    }

    /**
     * @param $item
     * @return string[][]
     */
    public function prepareData($item): array
    {
        return [
            [
                'label' => 'Visualize',
                'url' => $this->url->getUrlByRouteName('theme_index_view', ['id' => $item->getThemeId()]),
                'type' => 'url'
            ]
        ];
    }
}