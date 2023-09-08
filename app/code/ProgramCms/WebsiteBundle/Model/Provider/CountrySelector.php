<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Provider;

/**
 * Class CountrySelector
 * @package ProgramCms\WebsiteBundle\Model\Provider
 */
class CountrySelector extends \ProgramCms\UiBundle\Model\Provider\DataSource\Options
{
    /**
     * @return string[]
     */
    public function getOptionsArray(): array
    {
        return \Symfony\Component\Intl\Countries::getNames();
    }
}