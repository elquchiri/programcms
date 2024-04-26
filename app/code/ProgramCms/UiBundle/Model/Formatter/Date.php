<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Formatter;

use Exception;

/**
 * Class Date
 * @package ProgramCms\UiBundle\Model\Formatter
 */
class Date extends AbstractFormatter
{
    /**
     * @throws Exception
     */
    public function getValue($value)
    {
        if(!$value instanceof \DateTime) {
            throw new Exception('DateTime object expected');
        }
        return $value->format('Y-m-d H:i:s');
    }
}