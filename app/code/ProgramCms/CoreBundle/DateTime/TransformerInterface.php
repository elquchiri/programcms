<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\DateTime;

use DateTime;

/**
 * Interface TransformerInterface
 * @package ProgramCms\CoreBundle\DateTime
 */
interface TransformerInterface
{
    const TIMEZONE_CONFIG_PATH = 'general/locale_options/timezone';

    const DEFAULT_FORMAT = 'M d, Y, g:i:s A';

    /**
     * @param string $format
     * @param DateTime $dateTime
     * @return string
     */
    public function transform(DateTime $dateTime, string $format = self::DEFAULT_FORMAT): string;

    /**
     * @param DateTime $dateTime
     * @return string
     */
    public function timeAgo(DateTime $dateTime): string;
}