<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Helper;

/**
 * Class Language
 * @package ProgramCms\CoreBundle\Helper
 */
class Language
{
    /**
     * RTL Language codes
     * Arabic: ar
     * Hebrew: he (also iw in some contexts)
     * Persian (Farsi): fa
     * Urdu: ur
     * Pashto: ps
     * Kurdish: ku
     * Sindhi: sd
     * Uighur: ug
     * Yiddish: yi
     */
    public const RTL_LOCALES = ['ar', 'he', 'fa', 'ur', 'ps', 'ku', 'sd', 'ug', 'yi'];

    /**
     * @param string $locale
     * @return string
     */
    public function getDir(string $locale): string
    {
        $languageCode = preg_match('/^([a-z]{2})(?:_[A-Za-z]+)?$/', $locale, $matches) ? $matches[1] : 'en';

        return in_array($languageCode, self::RTL_LOCALES) ? 'rtl' : 'ltr';
    }
}