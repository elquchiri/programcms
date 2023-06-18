<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Provider\DataSource;

/**
 * Class YesNo
 * @package ProgramCms\UiBundle\Model\Provider\DataSource
 */
class YesNo extends Options
{
    /**
     * @return string[]
     */
    public function getOptionsArray(): array
    {
        return [
            "0" => "No",
            "1" => "Yes"
        ];
    }
}