<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Provider\DataSource;

/**
 * Class LocaleSelector
 * @package ProgramCms\UiBundle\Model\Provider\DataSource
 */
class LocaleSelector extends Options
{
    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        return \Symfony\Component\Intl\Locales::getNames();
    }
}