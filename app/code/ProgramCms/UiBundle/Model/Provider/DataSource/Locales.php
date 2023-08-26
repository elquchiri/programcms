<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Provider\DataSource;

use Symfony\Component\Intl\Locales as IntlLocales;

/**
 * Class Locales
 * @package ProgramCms\UiBundle\Model\Provider\DataSource
 */
class Locales extends Options
{
    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        return IntlLocales::getNames();
    }
}