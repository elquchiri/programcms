<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Model\Provider\DataSource;

/**
 * Class EnableDisable
 * @package ProgramCms\CatalogBundle\Model\Provider\DataSource
 */
class DisplayMode extends \ProgramCms\UiBundle\Model\Provider\DataSource\Options
{
    /**
     * @return string[]
     */
    public function getOptionsArray(): array
    {
        return [
            "1" => "Only Categories",
            "2" => "Categories and Posts"
        ];
    }
}