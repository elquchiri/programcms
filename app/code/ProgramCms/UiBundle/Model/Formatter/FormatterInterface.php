<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Formatter;

/**
 * Interface FormatterInterface
 * @package ProgramCms\UiBundle\Model\Formatter
 */
interface FormatterInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function getValue($value);
}