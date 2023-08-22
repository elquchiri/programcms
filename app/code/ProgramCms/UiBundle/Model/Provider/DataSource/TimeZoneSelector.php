<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Provider\DataSource;

/**
 * Class TimeZoneSelector
 * @package ProgramCms\UiBundle\Model\Provider\DataSource
 */
class TimeZoneSelector extends Options
{

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        return \DateTimeZone::listIdentifiers();
    }
}