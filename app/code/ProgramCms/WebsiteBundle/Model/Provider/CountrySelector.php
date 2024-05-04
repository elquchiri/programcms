<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Provider;

use ProgramCms\UiBundle\Model\Provider\DataSource\Options;
use Symfony\Component\Intl\Countries;

/**
 * Class CountrySelector
 * @package ProgramCms\WebsiteBundle\Model\Provider
 */
class CountrySelector extends Options
{
    /**
     * Returns list of translatable country names indexed with alpha2 codes as keys.
     * @return string[]
     */
    public function getOptionsArray(): array
    {
        return Countries::getNames();
    }
}