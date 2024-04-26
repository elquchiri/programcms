<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Formatter;

/**
 * Class Text
 * @package ProgramCms\UiBundle\Model\Formatter
 */
class Text extends AbstractFormatter
{
    /**
     * @param $value
     * @return mixed
     */
    public function getValue($value)
    {
        return $value;
    }
}